<?php

namespace App\Service;

use App\Amqp\Producer\MemberSignUpInitProducer;
use App\Event\MemberSigninEvent;
use App\Factory\EmailFactory;
use App\Model\Member;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Stringable\Str;
use League\OAuth2\Client\Provider\Google;

class AuthService extends AbstractService
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected IpinfoService $ipinfoService;

    #[Inject]
    protected UserAgentService $userAgentService;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 登录
     * @param string $username
     * @param string $password
     * @param string $ip_address
     * @param string $user_agent
     * @return ResultService
     */
    public function login(string $username, string $password, string $ip_address, string $user_agent): ResultService
    {
        // 获取系统登录失败限制次数
        $member_login_attempt_limit = $this->systemSettingService->getSettingByKey("member_login_attempt_limit");
        // 获取系统登录失败锁定分钟数
        $member_login_lock_minutes = $this->systemSettingService->getSettingByKey("member_login_lock_minutes");
        // 获取系统登录失败锁定秒数
        $member_login_lock_second = intval($member_login_lock_minutes * 60);
        // 查询登录失败次数
        $login_wrong_count = $this->redis->get("member_login_wrong:{$username}");
        if ($login_wrong_count != null) {
            if ((int)$login_wrong_count >= (int)$member_login_attempt_limit) {
                return ResultService::failure("Your account has been locked for {$member_login_lock_minutes} minutes. Please try again later.");
            }
        }

        // 查询会员
        $member = Member::where('email', $username)->orWhere('username', $username)->first();
        if (is_null($member)) {
            return ResultService::failure('The account or password is invalid.');
        }

        // 获取会员旧会话
        $old_session = $member->session;

        // 设置会员登录日志
        $member_log = new MemberSigninEvent();
        $member_log->member_id = $member->id;
        $member_log->status = 1;
        $member_log->status_message = "Login successful";
        $member_log->ip_address = $ip_address;
        $member_log->user_agent = $user_agent;

        // 验证邮箱
        if (!$member->is_email_verified) {
            return ResultService::failure('This account has not been verified by email, please check your email for verification instructions.');
        }

        // 验证状态
        if (!$member->status) {
            return ResultService::failure('This account is currently disabled, please contact customer support for assistance.');
        }

        // 验证密码
        if (!password_verify($password, $member->password)) {
            $this->redis->incr("member_login_wrong:{$username}");
            $this->redis->expire("member_login_wrong:{$username}", $member_login_lock_second);
            $member_log->status = 0;
            $member_log->status_message = "The account or password is invalid.";
            $this->event->dispatch($member_log);
            return ResultService::failure('The account or password is invalid.');
        }

        // 验证通过，更新会话信息
        $member->session = $this->session->getId();
        if (!$member->save()) {
            return ResultService::failure('Login failed, please try again later.');
        }

        // 删除用户的旧会话，强制用户重新登录
        $this->redis->del($old_session);

        // 发布登录事件
        $this->event->dispatch($member_log);

        // 设置登录会话
        $this->session->set('member_id', $member->id);

        // 设置安全令牌
        $this->session->set('csrf_token', md5(uniqid()));

        // 返回登录结果
        return ResultService::success('Successfully logged in.');
    }

    /**
     * 用户注册
     * @param string $username 用户名
     * @param string $email 邮箱
     * @param string $password 密码
     * @param string $ip_address IP地址
     * @param string $invite_code 邀请码
     * @return ResultService
     */
    public function signup(string $username, string $email, string $password, string $ip_address, string $invite_code): ResultService
    {
        // 查询是否关闭注册
        $member_register_enabled = $this->systemSettingService->getSettingByKey('member_register_enabled');
        if (!$member_register_enabled) {
            return ResultService::failure('New member registration is not currently being accepted.');
        }

        // 查询用户名
        $memberByUsername = Member::where('username', $username)->first();
        if ($memberByUsername) {
            return ResultService::failure('The username is already registered.');
        }

        // 查询邮箱
        $memberByEmail = Member::where('email', $email)->first();
        if ($memberByEmail) {
            return ResultService::failure('The email is already registered.');
        }

        // 查询邀请码
        if (!empty($invite_code)) {
            $memberByInviteCode = Member::where('invite_code', $invite_code)->first();
            $parent_id = $memberByInviteCode->id;
        } else {
            $parent_id = 0;
        }

        // 创建用户
        $member = new Member();
        $member->parent_id = $parent_id;
        $member->username = $username;
        $member->email = $email;
        $member->password = password_hash($password, PASSWORD_DEFAULT);
        $member->payment_password = password_hash($password, PASSWORD_DEFAULT);
        $member->register_ip = $ip_address;
        $member->invite_code = strtoupper(Str::random(8));
        $member->status = 1;
        if (!$member->save()) {
            return ResultService::failure('Registration failed, please try again later.');
        }

        // 生成一个Hash值，作为邮箱验证的token
        $email_verification_token = md5(uniqid());

        // 获取系统设置中的站点URL
        $site_url = $this->systemSettingService->getSettingByKey('site_url');

        // 生成激活链接
        $activate_url = "{$site_url}/verify/signup?token={$email_verification_token}";

        // 将token存储在缓存中，关联用户ID，设置过期时间为24小时
        $this->redis->set("signup_activate_token:{$email_verification_token}", 86400, $member->id);

        // 发送验证邮件
        $send_bool = EmailFactory::create('register')->send($email, ['link' => $activate_url]);
        if (!$send_bool) {
            return ResultService::failure('Registration successful, but failed to send verification email. Please contact support.');
        }

        // 获取会员注册初始化生产者
        $memberSignupInitProducer = new MemberSignUpInitProducer(json_encode(['member_id' => $member->id]));

        // 会员初始化
        $send_member_signup_init_queue_bool = $this->producer->produce($memberSignupInitProducer);
        if (!$send_member_signup_init_queue_bool) {
            return ResultService::failure('Registration successful, but failed to initialize member data. Please contact support.');
        }

        // 返回注册结果
        return ResultService::success('Registration successful! Please check your email to activate your account.');
    }

    /**
     * 谷歌登录
     * @return string
     */
    public function google_login(): string
    {
        // 谷歌授权登录客户端
        $google_client_id = $this->systemSettingService->getSettingByKey('google_client_id');
        // 谷歌授权登录密钥
        $google_client_secret = $this->systemSettingService->getSettingByKey('google_client_secret');
        // 谷歌授权绑定回调地址
        $google_callback_login_url = $this->systemSettingService->getSettingByKey('google_callback_login_url');
        // 获取谷歌登录客户端
        $provider = new Google(['clientId' => $google_client_id, 'clientSecret' => $google_client_secret, 'redirectUri'  => $google_callback_login_url]);
        // 获取授权URL
        $auth_url = $provider->getAuthorizationUrl();
        // 获取状态参数
        $state = $provider->getState();
        // 组装oauth
        $oauth = ['action' => 'login', 'state' => $state];
        // 设置会话
        $this->session->put('oauth', $oauth);
        return $auth_url;
    }
}