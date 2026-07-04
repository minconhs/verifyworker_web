<?php

namespace App\Crontab;

use App\Amqp\Producer\WalletCommissionToWalletTaskProducer;
use App\Model\WalletCommission;
use Hyperf\Amqp\Producer;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Crontab\Annotation\Crontab;
use Hyperf\Di\Annotation\Inject;

#[Crontab(rule: "0 0 * * *", name: "wallet_commission_crontab", callback: "execute", memo: "钱包佣金结算定时任务-凌晨0点执行")]
class WalletCommissionCrontab
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    private StdoutLoggerInterface $logger;

    public function execute(): void
    {
        // 查询所有余额大于1的佣金钱包
        $all_wallet_commission = WalletCommission::where('balance', '>', 1)->pluck('id');
        foreach ($all_wallet_commission as $wallet_id) {
            $wallet_commission_to_wallet_task_producer = new WalletCommissionToWalletTaskProducer($wallet_id);
            $this->producer->produce($wallet_commission_to_wallet_task_producer);
        }
    }
}