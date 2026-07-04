<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskOrderUpdateProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Model\TaskOrder;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Di\Annotation\Inject;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'task_order_update', routingKey: 'task_order_update', queue: 'task_order_update_queue', name: "TaskOrderUpdateConsumer", nums: 1)]
class TaskOrderUpdateConsumer extends ConsumerMessage
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取订单号
        $order_no       = $data['order_no'];
        // 获取状态
        $status         = $data['status'];

        try {
            // 更新状态
            $update = TaskOrder::where('order_no', $order_no)->update(['status' => $status]);
            if (!$update) {
                throw new BusinessException('task order update failed.');
            }
            return Result::ACK;
        } catch (\Throwable $e) {
            $this->logger->error('TaskOrderUpdateConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskOrderUpdateConsumerException,Retry limit reached, write failed.');
                }
            }
            $data['retry']++;
            // 获取生产者
            $task_order_update_producer = new TaskOrderUpdateProducer($data);
            // 发送到队列
            $this->producer->produce($task_order_update_producer);
            // 完成消费
            return Result::ACK;
        }
    }
}
