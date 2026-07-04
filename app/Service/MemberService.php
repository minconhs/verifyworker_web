<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\EmailFactory;
use App\Model\Member;
use Hyperf\Di\Annotation\Inject;

class MemberService extends AbstractService
{
    public function __construct()
    {
        $this->model = new Member();
    }

    #[Inject]
    protected IpinfoService $ipinfoService;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 根据会员ID获取会员信息
     * @param int $member_id
     * @return Member
     */
    public function getMemberInfoById(int $member_id): Member
    {
        // 定义缓存键
        $cache_key = "member_info:{$member_id}";
        // 尝试从 Redis 中获取会员信息
        $cache_value = $this->redis->get($cache_key);
        // 如果缓存中存在会员信息，则直接返回
        if ($cache_value) {
            return $this->model->forceFill(json_decode($cache_value, true));
        }
        // 查询数据库获取会员信息
        $member = $this->model->where('id', $member_id)->first();
        // 将会员信息缓存到 Redis，设置过期时间为 1 小时
        $this->redis->set($cache_key, 3600, $member->toJson());
        // 返回会员信息
        return $member;
    }

    /**
     * 获取账户安全分数
     * @param int $member_id 会员ID
     * @return int 账户安全分数，范围0-100
     */
    public function getSecurityScore(int $member_id): int
    {
        $member_info = $this->getMemberInfoById($member_id);
        $safetyScore = 0;
        if ($member_info->password) {
            $safetyScore += 25;
        }
        if ($member_info->payment_password) {
            $safetyScore += 25;
        }
        if ($member_info->status) {
            $safetyScore += 25;
        }
        if ($member_info->is_email_verified) {
            $safetyScore += 25;
        }
        return $safetyScore;
    }

    /**
     * 获取注册地点
     * @param int $member_id
     * @return string
     */
    public function getRegisterLocation(int $member_id): string
    {
        $cache_key = "member_register_location:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        // 获取会员信息
        $member = $this->getMemberInfoById($member_id);
        if (empty($member->register_ip)) {
            return "No Set";
        }
        // 获取注册地点
        $location = $this->ipinfoService->getLocation($member->register_ip);
        // 缓存注册地点
        $this->redis->set($cache_key, 120, $location);
        // 返回注册地点
        return $location;
    }

    /**
     * 修改邮箱
     * @param int $member_id
     * @param string $new_email
     * @param string $password
     * @return ResultService
     */
    public function changeEmail(int $member_id, string $new_email, string $password) : ResultService
    {
        // 查询用户是否存在
        $member = Member::where('id', $member_id)->first();
        if (is_null($member)) {
            return ResultService::failure('Member not found');
        }
        // 验证密码是否正确
        if (!password_verify($password, $member->password)) {
            return ResultService::failure('Password is incorrect');
        }
        // 验证新邮箱是否与旧邮箱相同
        if ($new_email === $member->email) {
            return ResultService::failure('New email cannot be the same as the current email');
        }
        // 验证新邮箱是否已被其他用户使用
        $existing_member = Member::where('email', $new_email)->where('id', '!=', $member->id)->first();
        if ($existing_member) {
            return ResultService::failure('The new email is already in use by another account');
        }

        // 获取系统设置中的站点URL
        $site_url = $this->systemSettingService->getSettingByKey('site_url');

        // 生成一个Hash值，作为邮箱验证的token
        $change_email_verification_token = md5(uniqid(), true);

        // 生成验证链接，包含token参数
        $verify_url = "{$site_url}/verify/email/change?token={$change_email_verification_token}";

        // 将token存储在缓存中，关联用户ID，设置过期时间为10分钟
        $this->redis->set("email_change_token:{$change_email_verification_token}", 600, json_encode(['member_id' => $member->id, 'email' => $new_email]));

        // 发送验证邮件
        EmailFactory::create('email_change')->send($new_email, ['link' => $verify_url]);

        // 返回成功结果，提示用户检查邮箱
        return ResultService::success('A verification email has been sent to your new email address. Please check your inbox and click the verification link to complete the email change process.');
    }

    /**
     * 修改密码
     * @param int $member_id
     * @param string $old_password
     * @param string $new_password
     * @return ResultService
     */
    public function changePassword(int $member_id, string $old_password, string $new_password) : ResultService
    {
        // 查询用户是否存在
        $member = Member::where('id', $member_id)->first();
        if (is_null($member)) {
            return ResultService::failure('User not found');
        }
        // 验证新密码是否与旧密码相同
        if (password_verify($new_password, $member->password)) {
            return ResultService::failure('New password cannot be the same as the old password');
        }

        // 验证旧密码是否正确
        if (!password_verify($old_password, $member->password)) {
            return ResultService::failure('Old password is incorrect');
        }

        // 更新密码
        $member->password = password_hash($new_password, PASSWORD_DEFAULT);
        if (!$member->save()) {
            return ResultService::failure('Failed to update password');
        }

        return ResultService::success('Password updated successfully');
    }

    /**
     * 修改支付密码
     * @param int $member_id
     * @param string $old_password
     * @param string $new_password
     * @return ResultService
     */
    public function changePaymentPassword(int $member_id, string $old_password, string $new_password) : ResultService
    {
        // 查询用户是否存在
        $member = Member::where('id', $member_id)->first();
        if (is_null($member)) {
            return ResultService::failure('User not found');
        }
        // 验证旧支付密码是否正确
        if (!password_verify($old_password, $member->payment_password)) {
            return ResultService::failure('Old payment password is incorrect');
        }
        // 验证新支付密码是否与旧支付密码相同
        if (password_verify($new_password, $member->payment_password)) {
            return ResultService::failure('New payment password cannot be the same as the old payment password');
        }
        // 更新支付密码
        $member->payment_password = password_hash($new_password, PASSWORD_DEFAULT);
        if (!$member->save()) {
            return ResultService::failure('Failed to update payment password');
        }

        return ResultService::success('Payment password updated successfully');
    }

    /**
     * 发送重置密码邮件
     * @param int $member_id
     * @return ResultService
     */
    public function sendResetPaymentPasswordEmail(int $member_id) : ResultService
    {
        // 查询用户是否存在
        $member = Member::where('id', $member_id)->first();
        if (is_null($member)) {
            return ResultService::failure('Member not found');
        }

        // 验证状态是否正常
        if (!$member->status) {
            return ResultService::failure('Member account is inactive, cannot reset payment password');
        }

        // 生成一个验证码
        $random_code = mt_rand(100000, 999999);

        // 将验证码存储在缓存中，关联用户ID，设置过期时间为10分钟
        $this->redis->set("reset_pay_password_token:{$random_code}", 600, $member->id);

        // 发送重置密码邮件，包含验证码
        EmailFactory::create('forgot_payment_password')->send($member->email, ['code' => $random_code]);

        return ResultService::success('The payment password reset verification code has been sent to your email address. Please check your inbox.');
    }

    /**
     * 重置支付密码
     * @param int $member_id
     * @param string $code
     * @param string $new_password
     * @return ResultService
     */
    public function resetPaymentPassword(int $member_id, string $code, string $new_password) : ResultService
    {
        // 查询用户是否存在
        $member = Member::where('id', $member_id)->first();
        if (is_null($member)) {
            return ResultService::failure('Member not found');
        }

        // 从缓存中获取验证码对应的用户ID
        $member_id = $this->redis->get("reset_pay_password_token:{$code}");
        if (!$member_id) {
            return ResultService::failure('Invalid or expired verification code');
        }

        // 验证会员ID是否匹配
        if ((int)$member_id != $member_id) {
            return ResultService::failure('Invalid verification code for this member');
        }
        // 验证新支付密码是否与旧支付密码相同
        if (password_verify($new_password, $member->payment_password)) {
            return ResultService::failure('New payment password cannot be the same as the old payment password');
        }

        // 更新支付密码
        $member->payment_password = password_hash($new_password, PASSWORD_DEFAULT);
        if (!$member->save()) {
            return ResultService::failure('Failed to update payment password');
        }

        // 删除缓存中的验证码
        $this->redis->del("reset_pay_password_token:{$code}");

        return ResultService::success('Payment password reset successfully');
    }
}
