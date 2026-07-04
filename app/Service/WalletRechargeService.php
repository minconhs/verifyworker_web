<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\WalletRecharge;

class WalletRechargeService extends AbstractService
{
    public function __construct()
    {
        $this->model = new WalletRecharge();
    }

    /**
     * 获取充值钱包信息
     * @param int $member_id
     * @return WalletRecharge|null
     */
    public function getWalletInfo(int $member_id): ?WalletRecharge
    {
        $cache_key = "wallet_recharge_info:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $this->model->forceFill(json_decode($cache_value, true));
        }
        // 查询钱包
        $wallet = $this->model->where('member_id', $member_id)->first();
        // 缓存
        $this->redis->set($cache_key, 300, $wallet->toJson());
        return $wallet;
    }
}
