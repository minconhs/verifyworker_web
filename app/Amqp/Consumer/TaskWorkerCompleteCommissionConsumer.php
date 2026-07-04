<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskWorkerCompleteCommissionProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Model\TaskCommission;
use App\Service\WalletCommissionService;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'task_worker_completed_commission', routingKey: 'task_worker_completed_commission', queue: 'task_worker_completed_commission_queue', name: "TaskWorkerCompleteCommissionConsumer", nums: 1)]
class TaskWorkerCompleteCommissionConsumer extends ConsumerMessage
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected WalletCommissionService $walletCommissionService;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取会员ID
        $member_id      = $data['member_id'];
        // 获取来源会员ID
        $form_member_id = $data['form_member_id'];
        // 获取订单号
        $order_no       = $data['order_no'];
        // 获取佣金金额
        $amount         = $data['amount'];

        Db::beginTransaction();
        try {

            $task_commission = new TaskCommission();
            $task_commission->member_id      = $member_id;
            $task_commission->form_member_id = $form_member_id;
            $task_commission->amount         = $amount;
            $task_commission->order_no       = $order_no;
            if (!$task_commission->save()) {
                throw new BusinessException("Order save failed");
            }

            // 增加佣金余额
            $this->walletCommissionService->commission_inc($member_id, $amount, $order_no);

            // 提交事物
            Db::commit();

            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error('TaskWorkerCompleteCommissionConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskWorkerCompleteCommissionConsumerException,Retry limit reached, write failed.');
                }
                // 完成消费
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $task_worker_complete_commission_producer = new TaskWorkerCompleteCommissionProducer($data);
            // 发送到队列
            $this->producer->produce($task_worker_complete_commission_producer);
            // 完成消费
            return Result::ACK;
        }
    }
}
