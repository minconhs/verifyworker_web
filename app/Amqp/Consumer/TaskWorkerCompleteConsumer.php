<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskWorkerCompleteCommissionProducer;
use App\Amqp\Producer\TaskWorkerCompleteProducer;
use App\Amqp\Producer\TaskWorkerStatsProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Model\TaskWorker;
use App\Service\MemberService;
use App\Service\SystemSettingService;
use App\Service\WalletTaskService;
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

#[Consumer(exchange: 'task_worker_completed', routingKey: 'task_worker_completed', queue: 'task_worker_completed_queue', name: "TaskWorkerCompleteConsumer", nums: 1)]
class TaskWorkerCompleteConsumer extends ConsumerMessage
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected MemberService $memberService;

    #[Inject]
    protected WalletTaskService $walletTaskService;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取会员ID
        $member_id      = $data['member_id'];
        // 获取订单号
        $order_no       = $data['order_no'];
        // 获取结算金额
        $task_amount    = $data['amount'];
        // 佣金结算金额
        $commission_amount = 0;
        // 获取提交结果
        $result         = $data['result'];
        // 获取任务负载
        $payload        = json_decode($data['payload'], true);
        // 定义当前时间
        $current_time = Carbon::now();

        // 获取任务抽成佣金比例
        $task_commission_rate = $this->systemSettingService->getSettingByKey('task_commission_rate');
        if (empty($task_commission_rate)) {
            $task_commission_rate = 0.1;
        }

        // 获取会员信息
        $member_info = $this->memberService->getMemberInfoById($member_id);

        // 是否有上级
        if ($member_info->parent_id > 0) {
            $commission_amount = bcmul($task_amount, $task_commission_rate, 5);
            // 计算实际结算金额, 结算金额减去佣金金额
            $task_amount = bcsub($task_amount, $commission_amount, 5);
        }

        Db::beginTransaction();
        try {
            // 定义更新订单数据
            $update_data['result'] = $result;
            $update_data['status'] = "completed";
            $update_data['amount'] = $task_amount;
            $update_data['completed_at'] = $current_time->copy()->toDateTimeString();
            // 更新订单数据
            $update = TaskWorker::where('order_no', $order_no)->where('status', 'processing')->update($update_data);
            if (!$update) {
                throw new BusinessException("Order update failed");
            }

            // 更新余额
            $this->walletTaskService->task_inc($member_id, $task_amount, $order_no);

            // 获取任务统计生产者
            $task_worker_stats_producer = new TaskWorkerStatsProducer(['member_id' => $member_id, 'order_no' => $order_no, 'task_type' => $payload['type'], 'status' => 'completed', 'amount' => $task_amount]);
            // 发送队列
            $send_task_worker_stats_producer = $this->producer->produce($task_worker_stats_producer);
            if (!$send_task_worker_stats_producer) {
                throw new BusinessException("TaskWorkerStatsProducer send failed");
            }

            // 佣金结算
            if ($member_info->parent_id > 0) {
                // 获取佣金生产者
                $task_worker_complete_commission_producer = new TaskWorkerCompleteCommissionProducer(['member_id' => $member_info->parent_id, 'form_member_id' => $member_id, 'amount' => $commission_amount, 'order_no' => $order_no]);
                // 发送队列
                $send_task_worker_complete_commission_producer = $this->producer->produce($task_worker_complete_commission_producer);
                if (!$send_task_worker_complete_commission_producer) {
                    throw new BusinessException("TaskWorkerCompleteCommissionProducer send failed");
                }
            }

            // 提交事物
            Db::commit();

            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error('TaskWorkerCompleteConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskWorkerCompleteConsumerException,Retry limit reached, write failed.');
                }
                // 完成消费
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $task_worker_complete_producer = new TaskWorkerCompleteProducer($data);
            // 发送到队列
            $this->producer->produce($task_worker_complete_producer);
            // 完成消费
            return Result::ACK;
        }
    }
}
