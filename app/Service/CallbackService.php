<?php

namespace App\Service;

use App\Event\MemberSigninEvent;
use App\Model\Member;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Di\Annotation\Inject;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Google;

class CallbackService extends AbstractService
{
    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 绑定谷歌
     * @param string $code
     * @param string $state
     * @return ResultService
     */
    public function google_bind(string $code, string $state): ResultService
    {
        $oauth_session = $this->session->get('oauth');
        // 验证会话数据
        if (!isset($oauth_session['state']) || !isset($oauth_session['action']) || !isset($oauth_session['member_id']) || $oauth_session['state'] !== $state) {
            return ResultService::failure('Invalid state parameter');
        }
        // 谷歌授权登录客户端
        $google_client_id = $this->systemSettingService->getSettingByKey('google_client_id');
        // 谷歌授权登录密钥
        $google_client_secret = $this->systemSettingService->getSettingByKey('google_client_secret');
        // 谷歌授权绑定回调地址
        $google_callback_bind_url = $this->systemSettingService->getSettingByKey('google_callback_bind_url');
        // 获取谷歌登录客户端
        $provider = new Google(['clientId' => $google_client_id, 'clientSecret' => $google_client_secret, 'redirectUri'  => $google_callback_bind_url]);
        try {
            // 获取谷歌令牌
            $token = $provider->getAccessToken('authorization_code', ['code' => $code]);
            // 获取谷歌用户信息
            $googleUser = $provider->getResourceOwner($token);
        } catch (GuzzleException $e) {
            return ResultService::failure("Request for Google service failed, please try again later.");
        } catch (IdentityProviderException $e) {
            return ResultService::failure("Google service response error, please try again later.");
        }
        // 获取谷歌用户ID
        $google_user_id = $googleUser->getId();
        // 获取授权信息
        $oauth = $this->model->where('member_id', $oauth_session['member_id'])->first();
        if (is_null($oauth)) {
            return ResultService::failure('Authorization information not found for the member.');
        }
        // 绑定谷歌账户
        $oauth->google_id = $google_user_id;
        if (!$oauth->save()) {
            return ResultService::failure('Google account linking failed, please try again later.');
        }
        // 删除授权信息缓存
        $this->redis->del("member_oauth_info:{$oauth_session['member_id']}");
        // 删除会话中的授权信息
        $this->session->forget('oauth');
        // 返回
        return ResultService::success('Google account linked successfully');
    }

    /**
     * 谷歌登录
     * @param string $code
     * @param string $state
     * @param string $ip_address
     * @param string $user_agent
     * @return ResultService
     */
    public function google_login(string $code, string $state,  string $ip_address, string $user_agent): ResultService
    {
        $oauth_session = $this->session->get('oauth');
        // 验证会话数据
        if (!isset($oauth_session['state']) || !isset($oauth_session['action']) || $oauth_session['state'] !== $state) {
            return ResultService::failure('Invalid state parameter');
        }
        // 谷歌授权登录客户端
        $google_client_id = $this->systemSettingService->getSettingByKey('google_client_id');
        // 谷歌授权登录密钥
        $google_client_secret = $this->systemSettingService->getSettingByKey('google_client_secret');
        // 谷歌授权绑定回调地址
        $google_callback_login_url = $this->systemSettingService->getSettingByKey('google_callback_login_url');
        // 获取谷歌登录客户端
        $provider = new Google(['clientId' => $google_client_id, 'clientSecret' => $google_client_secret, 'redirectUri'  => $google_callback_login_url]);
        try {
            // 获取谷歌令牌
            $token = $provider->getAccessToken('authorization_code', ['code' => $code]);
            // 获取谷歌用户信息
            $googleUser = $provider->getResourceOwner($token);
        } catch (GuzzleException $e) {
            return ResultService::failure("Request for Google service failed, please try again later.");
        } catch (IdentityProviderException $e) {
            return ResultService::failure("Google service response error, please try again later.");
        }
        // 获取谷歌用户ID
        $google_user_id = $googleUser->getId();
        // 获取授权信息
        $oauth = $this->model->where('google_id', $google_user_id)->first();
        if (is_null($oauth)) {
            return ResultService::failure('Google account not linked. Please register first.');
        }
        // 获取会员信息
        $member = Member::where('id', $oauth->member_id)->first();
        if (is_null($member)) {
            return ResultService::failure('Google account not linked. Please register first.');
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
}