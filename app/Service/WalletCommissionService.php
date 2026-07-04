<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Model\WalletCommission;
use App\Model\WalletFlow;

class WalletCommissionService extends AbstractService
{
    public function __construct()
    {
        $this->model = new WalletCommission();
    }

    /**
     * 获取佣金钱包信息
     * @param int $member_id
     * @return WalletCommission|null
     */
    public function getWalletInfo(int $member_id): ?WalletCommission
    {
        $cache_key = "wallet_commission_info:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $this->model->forceFill(json_decode($cache_value, true));
        }
        // 获取钱包
        $wallet = $this->model->where('member_id', $member_id)->first();
        // 缓存
        $this->redis->set($cache_key, 300, $wallet->toJson());
        return $wallet;
    }

    public function commission_inc(int $member_id, string $amount, string $order_no, string $operation_type = 'commission'): void
    {
        $wallet = $this->model->where('member_id', $member_id)->lockForUpdate()->first();
        if (!$wallet) {
            throw new BusinessException("commission wallet not found for member_id: {$member_id}");
        }
        $balance_before = $wallet->balance;
        $wallet->balance = bcadd($wallet->balance, $amount, 5);
        if (!$wallet->save()) {
            throw new BusinessException('Wallet balance increase failed, please try again later.');
        }
        $wallet_flow = new WalletFlow();
        $wallet_flow->member_id = $member_id;
        $wallet_flow->amount = $amount;
        $wallet_flow->balance_before = $balance_before;
        $wallet_flow->transaction_type = "income";
        $wallet_flow->operation_type = $operation_type;
        $wallet_flow->wallet_type = "commission";
        $wallet_flow->order_no = $order_no;
        $wallet_flow->description = "Task of {$amount} settlement for order commission {$order_no}";
        if (!$wallet_flow->save()) {
            throw new BusinessException('Failed to create wallet flow, please try again later.');
        }
    }

    public function commission_dec(int $member_id, string $amount, string $order_no, string $operation_type = 'commission'): void
    {
        $wallet = $this->model->where('member_id', $member_id)->lockForUpdate()->first();
        if (!$wallet) {
            throw new BusinessException("commission wallet not found for member_id: {$member_id}");
        }
        if (bccomp($amount, $wallet->balance, 5) === 1) {
            throw new BusinessException("Insufficient commission balance.");
        }
        $balance_before = $wallet->balance;
        $wallet->balance = bcsub($wallet->balance, $amount, 5);
        if (!$wallet->save()) {
            throw new BusinessException('Wallet balance deduction failed, please try again later.');
        }
        $wallet_flow = new WalletFlow();
        $wallet_flow->member_id = $member_id;
        $wallet_flow->amount = $amount;
        $wallet_flow->balance_before = $balance_before;
        $wallet_flow->transaction_type = "expense";
        $wallet_flow->operation_type = $operation_type;
        $wallet_flow->wallet_type = "commission";
        $wallet_flow->order_no = $order_no;
        if (!$wallet_flow->save()) {
            throw new BusinessException('Failed to create wallet flow, please try again later.');
        }
    }
}
