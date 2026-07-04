<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\WithdrawalAmount;
use Hyperf\Collection\Collection;

class WithdrawalAmountService extends AbstractService
{
    public function __construct()
    {
        $this->model = new WithdrawalAmount();
    }

    /**
     * 获取所有可用的提现金额选项
     * @return Collection
     */
    public function getAllWithdrawalAmount(): Collection
    {
        $cache_key = "all_withdraw_amount";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $this->model->hydrate(json_decode($cache_value, true));
        }
        $amounts = WithdrawalAmount::where('status', 1)->get();
        // 缓存结果，设置过期时间为300秒
        $this->redis->set($cache_key, 300, $amounts->toJson());
        // 返回结果
        return $amounts;
    }
}
