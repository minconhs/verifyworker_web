<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Member;
use App\Model\WalletTask;
use App\Model\Withdrawal;
use App\Model\WithdrawalAmount;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class WithdrawalService extends AbstractService
{
    public function __construct()
    {
        $this->model = new Withdrawal();
    }

    #[Inject]
    protected WalletTaskService $walletTaskService;

    /**
     * 获取提现成功的次数
     * @param int $member_id 会员ID
     * @return string 提现成功的次数
     */
    public function getSuccessfulWithdrawalsCount(int $member_id): string
    {
        $cache_key = "successful_withdrawals_count:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        // 查询提现成功的次数
        $count = Withdrawal::where('member_id', $member_id)->where('status', 1)->count();
        // 缓存结果，设置过期时间为120秒
        $this->redis->set($cache_key, 120, (string)$count);
        // 返回结果
        return (string)$count;
    }

    /**
     * 获取提现审核中的数量
     * @param int $member_id 会员ID
     * @return string 审核中的提现记录数量
     */
    public function getPendingWithdrawalsCount(int $member_id): string
    {
        $cache_key = "pending_withdrawals_count:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        // 查询审核中的提现记录数量
        $count = Withdrawal::where('member_id', $member_id)->where('status', 0)->count();
        // 缓存结果，设置过期时间为120秒
        $this->redis->set($cache_key, 120, (string)$count);
        // 返回结果
        return (string)$count;
    }

    /**
     * 获取中提现成功的总金额
     * @param int $member_id 会员ID
     * @return string 提现成功的总金额
     */
    public function getSuccessfulWithdrawalsTotalAmount(int $member_id): string
    {
        $cache_key = "successful_withdrawals_total_amount:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        // 查询提现成功的总金额
        $count = Withdrawal::where('member_id', $member_id)->where('status', 1)->sum('amount');
        // 缓存结果，设置过期时间为120秒
        $this->redis->set($cache_key, 120, (string)$count);
        // 返回结果
        return (string)$count;
    }

    /**
     * 提交提现请求
     * @param int $member_id 会员ID
     * @param int $amount_id 提现金额
     * @param string $method 提现方式
     * @param string $account 提现账户
     * @param string $password 提现密码
     * @return ResultService
     */
    public function submit_withdraw(int $member_id, int $amount_id, string $method, string $account, string $password): ResultService
    {
        // 当前时间
        $current_time = Carbon::now();

        // 查询会员信息
        $member = Member::where('id', $member_id)->first();
        // 验证状态
        if (!$member->status) {
            return ResultService::failure('Your account is abnormal and cannot perform this operation.');
        }
        // 验证激活
        if (!$member->is_email_verified) {
            return ResultService::failure('Your account is not activated and cannot perform this operation.');
        }
        // 验证支付密码
        if (!password_verify($password, $member->payment_password)) {
            return ResultService::failure('Your payment password is incorrect.');
        }
        // 查询提现金额选项
        $withdraw_amount = WithdrawalAmount::where('id', $amount_id)->where('status', 1)->first();
        if (!$withdraw_amount) {
            return ResultService::failure('The selected withdrawal amount is invalid. Please choose a valid option.');
        }
        if ($withdraw_amount->daily_limit > 0) {
            // 查询当天的提现次数
            $today_withdrawals_count = Withdrawal::where('member_id', $member_id)->where('amount_id', $amount_id)->whereBetween('created_at', [$current_time->copy()->startOfDay(), $current_time->copy()->endOfDay()])->count();
            if ($today_withdrawals_count >= $withdraw_amount->daily_limit) {
                return ResultService::failure("You have reached your daily withdrawal limit. Please try a different withdrawal amount.");
            }
        }
        if ($withdraw_amount->monthly_limit > 0) {
            // 查询当月的提现次数
            $month_withdrawals_count = Withdrawal::where('member_id', $member_id)->where('amount_id', $amount_id)->whereBetween('created_at', [$current_time->copy()->startOfMonth(), $current_time->copy()->endOfMonth()])->count();
            if ($month_withdrawals_count >= $withdraw_amount->daily_limit) {
                return ResultService::failure("This withdrawal amount has reached your monthly limit. Please try a different amount.");
            }
        }
        // 验证提现方式 PayPal
        if ($method=== 'paypal') {
            if (empty($account) || !filter_var($account, FILTER_VALIDATE_EMAIL)) {
                return ResultService::failure('Please provide a valid PayPal email address for withdrawal.');
            }
            // 验证提现金额是否满足PayPal的最低要求
            if ($withdraw_amount->amount < 100) {
                return ResultService::failure('The selected withdrawal amount does not meet the minimum requirement for PayPal withdrawals. Please choose a higher amount.');
            }
        }
        // 验证提现方式 Polygon
        if ($method === 'polygon') {
            if (empty($account) || !preg_match('/^0x[a-fA-F0-9]{40}$/', $account)) {
                return ResultService::failure('Please provide a valid Polygon wallet address for withdrawal.');
            }
        }
        // 查询钱包
        $wallet_task = WalletTask::where('member_id', $member_id)->first();
        if (!$wallet_task) {
            return ResultService::failure('Task wallet not found for the current user.');
        }
        // 验证用户余额是否足够
        if (bccomp($withdraw_amount->amount, $wallet_task->balance, 5) === 1) {
            return ResultService::failure('Insufficient balance for the selected withdrawal amount. Please choose a lower amount or earn more balance before trying again.');
        }

        // 生成提现订单号
        $order_no = date('YmdHis') . str_pad((string)$member_id, 8, '0', STR_PAD_LEFT) . mt_rand(1000, 9999);

        // 开启事务
        Db::beginTransaction();
        try {
            // 创建提现记录
            $withdrawal = new Withdrawal();
            $withdrawal->member_id = $member_id;
            $withdrawal->amount_id = $amount_id;
            $withdrawal->method = $method;
            $withdrawal->order_no = $order_no;
            $withdrawal->amount = $withdraw_amount->amount;
            $withdrawal->account = $account;
            $withdrawal->status_message = 'Application submitted, awaiting review.';
            if (!$withdrawal->save()) {
                return ResultService::success('Failed to create withdrawal record. Please try again later.');
            }
            // 扣钱包余额
            $this->walletTaskService->task_dec($member_id, $withdraw_amount->amount, $order_no, 'withdraw');
            // 提交事务
            Db::commit();
            // 清除用户钱包缓存
            $this->redis->del("wallet_task_info:{$member_id}");
            // 清除等待审核的提现记录数量缓存
            $this->redis->del("pending_withdrawals_count:{$member_id}");
            // 返回结果
            return ResultService::success('Your withdrawal request has been submitted successfully and is pending review.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return ResultService::failure('An error occurred while processing your withdrawal request. Please try again later.');
        }
    }
}
