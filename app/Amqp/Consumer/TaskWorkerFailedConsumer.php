<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskWorkerFailedProducer;
use App\Amqp\Producer\TaskWorkerStatsProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Model\TaskWorker;
use Carbon\Carbon;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'task_worker_failed', routingKey: 'task_worker_failed', queue: 'task_worker_failed_queue', name: "TaskWorkerFailedConsumer", nums: 1)]
class TaskWorkerFailedConsumer extends ConsumerMessage
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
        // 获取任务负载
        $payload        = json_decode($data['payload'], true);
        // 定义当前时间
        $current_time = Carbon::now();


        Db::beginTransaction();
        try {
            // 定义更新订单数据
            $update_data['status'] = "failed";
            $update_data['amount'] = 0;
            $update_data['cancel_at'] = $current_time->copy()->toDateTimeString();
            $update_data['completed_at'] = $current_time->copy()->toDateTimeString();
            // 更新订单数据
            $update = TaskWorker::where('order_no', $order_no)->where('status', 'processing')->update($update_data);
            if (!$update) {
                throw new BusinessException("Order update failed");
            }

            // 获取任务统计生产者
            $task_worker_stats_producer = new TaskWorkerStatsProducer(['member_id' => $member_id, 'order_no' => $order_no, 'task_type' => $payload['type'], 'status' => 'failed', 'amount' => 0]);
            // 发送队列
            $send_task_worker_stats_producer = $this->producer->produce($task_worker_stats_producer);
            if (!$send_task_worker_stats_producer) {
                throw new BusinessException("TaskWorkerStatsProducer send failed");
            }

            Db::commit();

            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error('TaskWorkerCancelConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskWorkerCancelConsumerException,Retry limit reached, write failed.');
                }
                // 完成消费
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $task_worker_failed_producer = new TaskWorkerFailedProducer($data);
            // 发送到队列
            $this->producer->produce($task_worker_failed_producer);
            // 完成消费
            return Result::ACK;
        }
    }
}
