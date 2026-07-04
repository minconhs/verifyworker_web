<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskWorkerStatsProducer;
use App\Amqp\Producer\WalletCommissionToWalletTaskProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Model\TaskWorker;
use App\Model\WalletCommission;
use App\Service\WalletCommissionService;
use App\Service\WalletTaskService;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'wallet_commission_to_wallet_task', routingKey: 'wallet_commission_to_wallet_task', queue: 'wallet_commission_to_wallet_task_queue', name: "WalletCommissionToWalletTaskConsumer", nums: 1)]
class WalletCommissionToWalletTaskConsumer extends ConsumerMessage
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected WalletCommissionService $walletCommissionService;

    #[Inject]
    protected WalletTaskService $walletTaskService;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取钱包ID
        $wallet_id      = $data;

        echo "佣金转任务余额:" . $wallet_id . PHP_EOL;

        // 开启事物
        Db::beginTransaction();
        try {

            // 查询钱包
            $wallet_commission = WalletCommission::where('id', $wallet_id)->lockForUpdate()->first();

            // 获取佣金余额
            $commission_balance = $wallet_commission->balance;

            // 生成订单号
            $dec_order_no = date('YmdHis') . str_pad((string)$wallet_commission->member_id, 8, '0', STR_PAD_LEFT) . mt_rand(1000, 9999);

            // 扣除钱包佣金
            $this->walletCommissionService->commission_dec($wallet_commission->member_id, $commission_balance, $dec_order_no);

            // 生成订单号
            $inc_order_no = date('YmdHis') . str_pad((string)$wallet_commission->member_id, 8, '0', STR_PAD_LEFT) . mt_rand(1000, 9999);

            // 增加钱包余额
            $this->walletTaskService->task_inc($wallet_commission->member_id, $commission_balance, $inc_order_no);

            // 完成事物
            Db::commit();

            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error('WalletCommissionToWalletTaskConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('WalletCommissionToWalletTaskConsumerException,Retry limit reached, write failed.');
                }
                // 完成队列
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $wallet_commission_to_wallet_task_producer = new WalletCommissionToWalletTaskProducer($data);
            // 发送队列
            $this->producer->produce($wallet_commission_to_wallet_task_producer);

            return Result::ACK;
        }
    }
}
