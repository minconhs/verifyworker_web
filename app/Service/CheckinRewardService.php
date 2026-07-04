<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\CheckinReward;
use Hyperf\Collection\Collection;

class CheckinRewardService extends AbstractService
{
    public function __construct()
    {
        $this->model = new CheckinReward();
    }

    /**
     * 获取所有的奖励
     * @return Collection
     */
    public function getAllCheckInReward(): Collection
    {
        $cache_key = "all_checkin_reward";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $this->model->hydrate(json_decode($cache_value, true));
        }
        $amounts = $this->model->where('status', 1)->get();
        // 缓存结果，设置过期时间为300秒
        $this->redis->set($cache_key, 300, $amounts->toJson());
        // 返回结果
        return $amounts;
    }
}
