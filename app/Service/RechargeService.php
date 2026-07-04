<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Member;
use App\Model\Recharge;
use Hyperf\Di\Annotation\Inject;

class RechargeService extends AbstractService
{
    #[Inject]
    protected MinxPayService $minxPayService;

    #[Inject]
    protected SystemSettingService $systemSettingService;
    
    public function __construct()
    {
        $this->model = new Recharge();
    }

    /**
     * 提交充值订单
     * @param int $member_id 会员ID
     * @param string $amount 充值金额
     * @param string $method 充值方式
     * @return ResultService
     */
    public function submit(int $member_id, string $amount, string $method): ResultService
    {
        // 查询是否允许充值
        $wallet_recharge_enabled = $this->systemSettingService->getSettingByKey('wallet_recharge_enabled');
        if (!$wallet_recharge_enabled) {
            return ResultService::failure('The current deposit is under maintenance and cannot be deposited.');
        }
        // 查询最小充值金额
        $wallet_min_recharge_amount = $this->systemSettingService->getSettingByKey('wallet_min_recharge_amount');
        if (bccomp($wallet_min_recharge_amount, $amount) === 1) {
            return ResultService::failure('The minimum deposit amount must be $'.$wallet_min_recharge_amount.'.');
        }
        // paypal 维护中
        if ($method === 'paypal') {
            return ResultService::failure('PayPal recharge is currently under maintenance. Please choose another method.');
        }

        // 查询会员
        $member = Member::where('id', $member_id)->first();
        // 验证邮箱
        if (!$member->is_email_verified) {
            return ResultService::failure('This account has not been verified by email, please check your email for verification instructions.');
        }
        // 验证状态
        if (!$member->status) {
            return ResultService::failure('This account is currently disabled, please contact customer support for assistance.');
        }
        
        // 生成充值订单号
        $order_no = date('YmdHis') . str_pad((string)$member_id, 8, '0', STR_PAD_LEFT) . mt_rand(1000, 9999);

        // 创建充值订单
        $recharge = new Recharge();
        $recharge->member_id = $member_id;
        $recharge->order_no = $order_no;
        $recharge->amount = $amount;
        $recharge->status = 0;
        $recharge->method = $method;
        if (!$recharge->save()) {
            return ResultService::failure('Failed to create recharge order, please try again later.');
        }
        // 调用minx支付
        return $this->minxPayService->create($amount, $order_no);
    }

    /**
     * 获取成功充值金额
     * @param int $member_id
     * @return string
     */
    public function getSuccessfulRechargeAmount(int $member_id): string
    {
        $cache_key = "total_recharge_amount:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        // 查询数据库统计金额
        $total_amount = $this->model->where('member_id', $member_id)->where('status', 1)->sum('amount');
        // 将结果缓存到Redis，设置过期时间为120秒
        $this->redis->set($cache_key, 120, (string)$total_amount);
        // 返回结果
        return (string)$total_amount;
    }
}
