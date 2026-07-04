<?php

namespace App\Service;

use App\Factory\EmailFactory;
use App\Model\Member;
use Hyperf\Di\Annotation\Inject;

class ForgotService extends AbstractService
{
    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 忘记密码
     * @param string $email
     * @return ResultService
     */
    public function forgot(string $email) : ResultService
    {
        // 通过邮箱查询用户
        $member = Member::where('email', $email)->first();
        if (is_null($member)) {
            return ResultService::success('We have sent a password reset email to the email address you provided. Please check your inbox.');
        }
        // 验证用户是否邮件验证
        if (!$member->is_email_verified) {
            return ResultService::success('We have sent a password reset email to the email address you provided. Please check your inbox.');
        }
        // 验证用户状态
        if (!$member->status) {
            return ResultService::success('We have sent a password reset email to the email address you provided. Please check your inbox.');
        }

        // 获取系统设置中的站点URL
        $site_url = $this->systemSettingService->getSettingByKey('site_url');

        // 生成一个Hash值，作为重置密码的token
        $forgot_password_token = md5(uniqid());

        // 生成重置密码链接
        $reset_url = "{$site_url}/forgot/verify?token={$forgot_password_token}";

        // 将token存储在缓存中，关联用户ID，设置过期时间为30分钟
        $this->redis->set("forgot_password_token:{$forgot_password_token}", 1800, $member->id);

        // 发送重置密码邮件
        $send_bool = EmailFactory::create('forgot_password')->send($email, ['link' => $reset_url]);
        if (!$send_bool) {
            return ResultService::failure('Failed to send password reset email, please contact support.');
        }

        // 返回结果
        return ResultService::success('We have sent a password reset email to the email address you provided. Please check your inbox.');
    }

    /**
     * 验证密钥
     * @param string $token
     * @return ResultService
     */
    public function verify(string $token): ResultService
    {
        $cache_key = "forgot_password_token:{$token}";
        // 从缓存中获取token关联的数据
        $cache_value = $this->redis->get($cache_key);
        if (!$cache_value) {
            return ResultService::failure('Invalid or expired password reset link. Please request a new password reset link.');
        }
        return ResultService::success('Password reset token is valid.');
    }

    /**
     * 重置密码
     * @param string $token
     * @param string $password
     * @return ResultService
     */
    public function reset_password(string $token, string $password) : ResultService
    {
        $cache_key = "forgot_password_token:{$token}";
        // 从缓存中获取token关联的用户ID
        $member_id = $this->redis->get($cache_key);
        if (!$member_id) {
            return ResultService::failure('Invalid or expired password reset link. Please request a new password reset link.');
        }
        // 查询用户信息
        $memberInfo = Member::where('id', $member_id)->first();
        if (is_null($memberInfo)) {
            return ResultService::failure('User not found. Please try again.');
        }
        // 更新密码
        $memberInfo->password = password_hash($password, PASSWORD_DEFAULT);
        if (!$memberInfo->save()) {
            return ResultService::failure('Failed to reset password. Please contact support.');
        }

        // 删除用户的旧会话，强制用户重新登录
        if ($memberInfo->session) {
            $this->redis->del($memberInfo->session);
        }

        // 删除缓存中的token
        $this->redis->del($cache_key);

        // 返回结果
        return ResultService::success('Password reset successfully. You can now log in with your new password.');
    }
}