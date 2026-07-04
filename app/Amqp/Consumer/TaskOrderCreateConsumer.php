<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskOrderCreateProducer;
use App\Amqp\Producer\TaskWorkerCreateProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Model\TaskOrder;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'task_order_create', routingKey: 'task_order_create', queue: 'task_order_create_queue', name: "TaskOrderCreateConsumer", nums: 1)]
class TaskOrderCreateConsumer extends ConsumerMessage
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取会员ID
        $member_id      = $data['member_id'];
        // 获取订单号
        $order_no       = $data['order_no'];
        // 获取平台类型
        $platform       = $data['platform'];
        // 获取任务类型
        $task_type      = $data['task_type'];

        Db::beginTransaction();
        try {
            // 新建订单
            $task_order = new TaskOrder();
            $task_order->member_id = $member_id;
            $task_order->order_no  = $order_no;
            $task_order->platform  = $platform;
            $task_order->task_type = $task_type;
            $task_order->status    = 1;
            $task_order->status_message =  "Orders are awaiting allocation.";
            if (!$task_order->save()) {
                throw new BusinessException("保存订单失败");
            }

            // 获取员工任务创建生产者
            $task_worker_create_producer = new TaskWorkerCreateProducer($task_order->toArray());
            // 发送员工任务创建队列
            $send_task_worker_create_producer = $this->producer->produce($task_worker_create_producer);
            if (!$send_task_worker_create_producer) {
                throw new BusinessException("员工任务创建队列发送失败");
            }

            // 提交事物
            Db::commit();

            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error('TaskOrderCreateConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskOrderCreateConsumerException,Retry limit reached, write failed.');
                }

                // 定义任务订单标记缓存键
                $task_worker_order_mark_cache_key = "task_worker_order_mark:{$member_id}";
                // 定义任务订单状态缓存键
                $task_worker_order_status_cache_key = "task_worker_order_status:{$order_no}";
                // 删除Redis缓存
                $this->redis->del($task_worker_order_mark_cache_key,$task_worker_order_status_cache_key);
                // 完成队列
                return Result::ACK;
            }
            $data['retry']++;
            // 获取任务订单队列创建生产者
            $taskOrderProducer = new TaskOrderCreateProducer($data);
            // 发送到队列，无需序列化，直接发送数组
            $this->producer->produce($taskOrderProducer);

            return Result::ACK;
        }
    }
}
