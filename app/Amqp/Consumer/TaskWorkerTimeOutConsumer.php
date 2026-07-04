<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskWorkerStatsProducer;
use App\Amqp\Producer\TaskWorkerTimeOutProducer;
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

#[Consumer(exchange: 'task_worker_timeout', routingKey: 'task_worker_timeout', queue: 'task_worker_timeout_queue', name: "TaskWorkerTimeOutConsumer", nums: 1)]
class TaskWorkerTimeOutConsumer extends ConsumerMessage
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取订单号
        $order_no     = $data;
        // 定义当前时间
        $current_time = Carbon::now();

        // 开启事物
        Db::beginTransaction();
        try {
            // 查询订单是否存在
            $task_worker = TaskWorker::where('order_no', $order_no)->first();
            if (!$task_worker) {
                return Result::ACK;
            }
            // 检查状态
            if ($task_worker->status !== 'processing') {
                return Result::ACK;
            }
            // 更新订单
            $task_worker->amount = 0;
            $task_worker->status = "timeout";
            $task_worker->completed_at = $current_time->copy()->toDateTimeString();
            if (!$task_worker->save()) {
                throw new BusinessException("Order saving failed");
            }

            // 获取任务负载
            $payload = json_decode($task_worker->payload,true);

            // 获取任务统计生产者
            $task_worker_stats_producer = new TaskWorkerStatsProducer(['member_id' => $task_worker->member_id, 'order_no' => $task_worker->order_no, 'task_type' => $payload['type'], 'status' => 'timeout', 'amount' => 0]);
            // 发送队列
            $send_task_worker_stats_producer = $this->producer->produce($task_worker_stats_producer);
            if (!$send_task_worker_stats_producer) {
                throw new BusinessException("TaskWorkerStatsProducer send failed");
            }

            // 完成事物
            Db::commit();

            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error('TaskWorkerTimeOutConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskWorkerTimeOutConsumerException,Retry limit reached, write failed.');
                }
                // 完成队列
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $task_worker_timeout_producer = new TaskWorkerTimeOutProducer($data);
            // 发送队列
            $this->producer->produce($task_worker_timeout_producer);

            return Result::ACK;
        }
    }
}
