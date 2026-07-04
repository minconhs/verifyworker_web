<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskWorkerStatsProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Model\TaskWorkerStat;
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

#[Consumer(exchange: 'task_worker_stats', routingKey: 'task_worker_stats', queue: 'task_worker_stats_queue', name: "TaskWorkerStatsConsumer", nums: 1)]
class TaskWorkerStatsConsumer extends ConsumerMessage
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
        // 获取任务类型
        $task_type      = $data['task_type'];
        // 获取统计状态
        $status         = $data['status'];
        // 获取统计金额
        $amount         = $data['amount'];
        // 定义当前时间
        $current_time   = Carbon::now();

        try {
            // 查询是否有当天的统计数据
            $task_worker_stats = TaskWorkerStat::where('member_id', $member_id)->where('task_type', $task_type)->where('date', $current_time->copy()->toDateString())->first();
            if (!$task_worker_stats) {
                $task_worker_stats = new TaskWorkerStat();
                $task_worker_stats->member_id = $member_id;
                $task_worker_stats->task_type = $task_type;
                $task_worker_stats->total     = 1;
                $task_worker_stats->completed = $status == 'completed' ? 1 : 0;
                $task_worker_stats->cancel    = $status == 'cancel' ? 1 : 0;
                $task_worker_stats->failed    = $status == 'failed' ? 1 : 0;
                $task_worker_stats->timeout   = $status == 'timeout' ? 1 : 0;
                $task_worker_stats->date      = $current_time->copy()->toDateString();
                $task_worker_stats->total_amount = strval($amount);
            } else {
                $task_worker_stats->total     = $task_worker_stats->total + 1;
                $task_worker_stats->completed = $status == 'completed' ? $task_worker_stats->completed + 1 : $task_worker_stats->completed;
                $task_worker_stats->cancel    = $status == 'cancel' ? $task_worker_stats->cancel + 1 : $task_worker_stats->cancel;
                $task_worker_stats->failed    = $status == 'failed' ? $task_worker_stats->failed + 1 : $task_worker_stats->failed;
                $task_worker_stats->timeout   = $status == 'timeout' ? $task_worker_stats->timeout + 1 : $task_worker_stats->timeout;
                $task_worker_stats->total_amount = bcadd($task_worker_stats->total_amount, strval($amount),5);
            }
            if (!$task_worker_stats->save()) {
                throw new BusinessException("Order save failed");
            }
            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            $this->logger->error('TaskWorkerStatsConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskWorkerStatsConsumerException,Retry limit reached, write failed.');
                }
                // 完成队列
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $task_worker_stats_producer = new TaskWorkerStatsProducer($data);
            // 发送队列
            $this->producer->produce($task_worker_stats_producer);
            // 完成消费
            return Result::ACK;
        }
    }
}
