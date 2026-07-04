<?php

namespace App\Service;

use App\Model\Member;
use App\Model\TaskCommission;
use Hyperf\Di\Annotation\Inject;

class ReferralService extends AbstractService
{
    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 获取推荐人数
     * @param int $member_id
     * @return string 推荐人数
     */
    public function getReferralCount(int $member_id): string
    {
        $cache_key = "welfare_referral_count:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value){
            return $cache_value;
        }
        // 查询数据库获取推荐人数
        $count = Member::where('parent_id', $member_id)->count();
        // 将结果缓存120秒
        $this->redis->set($cache_key,120, $count);
        // 返回推荐人数
        return $count;
    }

    /**
     * 获取总推荐奖励金额
     * @param int $member_id
     * @return string 推荐奖励金额
     */
    public function getReferralEarnings(int $member_id): string
    {
        $cache_key = "welfare_referral_earnings:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value){
            return $cache_value;
        }
        // 查询数据库获取总推荐奖励金额
        $amount = TaskCommission::where('member_id', $member_id)->sum('amount');
        // 将结果缓存120秒
        $this->redis->set($cache_key,120, (string)$amount);
        // 返回总推荐奖励金额
        return $amount;
    }

    /**
     * 获取推荐码
     * @param int $member_id
     * @return string 推荐码
     */
    public function getReferralCode(int $member_id): string
    {
        $cache_key = "welfare_referral_code:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value){
            return $cache_value;
        }
        // 查询数据库获取推荐码
        $invite_code = Member::where('id', $member_id)->value('invite_code');
        // 将结果缓存120秒
        $this->redis->set($cache_key,120, $invite_code);
        // 返回推荐码
        return $invite_code;
    }

    /**
     * 获取推荐链接
     * @param int $member_id
     * @return string 推荐链接
     */
    public function getReferralLink(int $member_id): string
    {
        // 获取系统站点URL
        $site_url = $this->systemSettingService->getSettingByKey('site_url');
        // 获取推荐码
        $invite_code = $this->getReferralCode($member_id);
        // 构建推荐链接
        return "{$site_url}/auth/signup?referral=" . $invite_code;
    }
}