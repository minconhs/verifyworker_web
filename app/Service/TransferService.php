<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Model\Member;
use App\Model\Transfer;
use App\Model\WalletTask;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class TransferService extends AbstractService
{
    public function __construct()
    {
        $this->model = new Transfer();
    }

    #[Inject]
    protected WalletTaskService $walletTaskService;

    /**
     * 获取总转账金额
     * @param int $member_id 会员ID
     * @return string 总转账金额
     */
    public function getTotalTransferAmount(int $member_id): string
    {
        $cache_key = "total_transfer_amount:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        // 从数据库查询总转账金额
        $total_amount = Transfer::where('member_id', $member_id)->sum('amount');
        // 将结果缓存到Redis，设置过期时间为120秒
        $this->redis->set($cache_key, 120, (string)$total_amount);
        // 返回总转账金额
        return (string)$total_amount;
    }

    /**
     * 获取转账次数
     * @param int $member_id 会员ID
     * @return int 转账次数
     */
    public function getTotalTransferCount(int $member_id): int
    {
        $cache_key = "total_transfer_count:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return (int)$cache_value;
        }
        // 从数据库查询转账次数
        $total_count = Transfer::where('member_id', $member_id)->count();
        // 将结果缓存到Redis，设置过期时间为120秒
        $this->redis->set($cache_key, 120, (string)$total_count);
        // 返回转账次数
        return $total_count;
    }

    /**
     * 提交转账订单
     * @param int $member_id 会员ID
     * @param string $email 收款账户（邮箱）
     * @param string $password 支付密码
     * @param string $amount 转账金额
     * @return ResultService
     */
    public function submit_transfer(int $member_id, string $email, string $password, string $amount): ResultService
    {
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

        // 查询收款会员信息
        $to_member = Member::where('id', '!=', $member_id)->where('email', $email)->first();
        if (is_null($to_member)) {
            return ResultService::failure('The recipient account is currently not supported or does not exist.');
        }
        // 验证状态
        if (!$to_member->status) {
            return ResultService::failure('The recipient account is abnormal and cannot perform this operation.');
        }
        // 验证激活
        if (!$to_member->is_email_verified) {
            return ResultService::failure('The recipient account has not completed email verification.');
        }

        // 查询钱包
        $wallet_task = WalletTask::where('member_id', $member_id)->first();
        if (!$wallet_task) {
            return ResultService::failure('Task wallet not found for the current user.');
        }

        // 验证用户余额是否足够
        $cmp = bccomp($amount, $wallet_task->balance, 5);
        if ($cmp === 1) {
            return ResultService::failure('Insufficient current account balance.');
        }

        // 生成提现订单号
        $order_no = date('YmdHis') . str_pad((string)$member_id, 8, '0', STR_PAD_LEFT) . mt_rand(1000, 9999);
        // 计算手续费
        $fee = bcmul($amount, '0.15', 5);
        // 计算实际所得
        $actual_amount = bcsub($amount, $fee, 5);

        Db::beginTransaction();
        try {
            // 写转账单
            $transferOrder = new Transfer();
            $transferOrder->member_id = $member->id;
            $transferOrder->to_member_id = $to_member->id;
            $transferOrder->order_no = $order_no;
            $transferOrder->amount = $amount;
            $transferOrder->fee = $fee;
            $transferOrder->actual_amount = $actual_amount;
            if (!$transferOrder->save()) {
                throw new BusinessException('Failed to create transfer order, please try again later.');
            }

            // 扣会员钱包余额
            $this->walletTaskService->task_dec($transferOrder->member_id, $transferOrder->amount, $order_no, 'transfer');

            // 增收款方钱包
            $this->walletTaskService->task_inc($transferOrder->to_member_id, $transferOrder->actual_amount, $order_no, 'transfer');

            // 提交事务
            Db::commit();

            // 删除会员钱包缓存
            $this->redis->del("wallet_task_info:" . $transferOrder->member_id);
            $this->redis->del("wallet_task_info:" . $transferOrder->to_member_id);

            // 返回成功结果
            return ResultService::success("Transfer submitted successfully, currently being processed.");
        } catch (\Throwable $e) {
            Db::rollBack();
            return ResultService::failure('Transfer failed, please try again later.');
        }
    }
}
