<?php

namespace App\Service;

use App\Model\Member;

class VerifyService extends AbstractService
{
    /**
     * 验证注册邮箱
     * @param string $token
     * @return ResultService
     */
    public function signup_verify(string $token): ResultService
    {
        // 定义缓存键
        $cache_key = "signup_activate_token:{$token}";
        // 从缓存中获取token关联的用户ID
        $cache_value = $this->redis->get($cache_key);
        if (!$cache_value) {
            return ResultService::failure('Invalid or expired activation link. Please sign up again.');
        }
        // 查询用户信息
        $memberInfo = Member::where('id', $cache_value)->where('role', 'member')->first();
        if (is_null($memberInfo)) {
            return ResultService::failure('User not found. Please sign up again.');
        }
        // 激活用户
        $memberInfo->is_email_verified = 1;
        if (!$memberInfo->save()) {
            return ResultService::failure('Failed to activate account. Please contact support.');
        }
        // 删除缓存中的token
        $this->redis->del($cache_key);
        // 返回成功结果
        return ResultService::success('Account activated successfully. You can now log in.');
    }

    /**
     * 验证变更邮箱
     * @param string $token
     * @return ResultService
     */
    public function email_change_verify(string $token): ResultService
    {
        $cache_key = "email_change_token:{$token}";
        // 从缓存中获取token关联的数据
        $cache_value = $this->redis->get($cache_key);
        if (!$cache_value) {
            return ResultService::failure('Invalid or expired email change link. Please try again.');
        }
        // 解析数据
        $data = json_decode($cache_value, true);
        if (!isset($data['member_id']) || !isset($data['email'])) {
            return ResultService::failure('Invalid token data. Please try again.');
        }
        // 查询用户信息
        $memberInfo = Member::where('id', $data['member_id'])->where('role', 'member')->first();
        if (is_null($memberInfo)) {
            return ResultService::failure('User not found. Please try again.');
        }
        // 更新邮箱地址
        $memberInfo->email = $data['email'];
        if (!$memberInfo->save()) {
            return ResultService::failure('Failed to change email. Please contact support.');
        }
        // 删除缓存中的token
        $this->redis->del($cache_key);
        // 删除会员详情
        $this->redis->del("member_info:{$memberInfo->id}");
        // 返回成功结果
        return ResultService::success('Email address changed successfully.');
    }

    /**
     * 验证重置密码
     * @param string $token
     * @return ResultService
     */
    public function forgot_password(string $token): ResultService
    {
        $cache_key = "forgot_password_token:{$token}";
        // 从缓存中获取token关联的数据
        $cache_value = $this->redis->get($cache_key);
        if (is_null($cache_value)) {
            return ResultService::failure('Invalid or expired password reset link. Please request a new password reset link.');
        }
        return ResultService::success('Password reset token is valid.');
    }
}