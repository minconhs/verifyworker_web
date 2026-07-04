<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\MemberOauth;
use Hyperf\Di\Annotation\Inject;
use League\OAuth2\Client\Provider\Google;

class MemberOauthService extends AbstractService
{
    #[Inject]
    protected SystemSettingService $systemSettingService;

    public function __construct()
    {
        $this->model = new MemberOauth();
    }

    /**
     * 获取会员第三方登录信息
     * @param int $member_id
     * @return MemberOauth
     */
    public function getMemberOauthInfo(int $member_id): MemberOauth
    {
        $cache_key = "member_oauth_info:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return  $this->model->forceFill(json_decode($cache_value, true));
        }
        // 数据库查询会员第三方登录信息
        $oauth_info = $this->model->where('member_id', $member_id)->first();
        // 缓存会员第三方登录信息，设置过期时间为300秒
        $this->redis->set($cache_key, 300, $oauth_info->toJson());
        // 返回会员第三方登录信息
        return $oauth_info;
    }

    /**
     * 绑定谷歌登录
     * @param int $member_id
     * @return string
     */
    public function google_bind(int $member_id): string
    {
        // 谷歌授权登录客户端
        $google_client_id = $this->systemSettingService->getSettingByKey('google_client_id');
        // 谷歌授权登录密钥
        $google_client_secret = $this->systemSettingService->getSettingByKey('google_client_secret');
        // 谷歌授权绑定回调地址
        $google_callback_bind_url = $this->systemSettingService->getSettingByKey('google_callback_bind_url');
        // 获取谷歌登录客户端
        $provider = new Google(['clientId' => $google_client_id, 'clientSecret' => $google_client_secret, 'redirectUri'  => $google_callback_bind_url]);
        // 获取授权URL
        $auth_url = $provider->getAuthorizationUrl();
        // 获取状态参数
        $state = $provider->getState();
        // 组装oauth
        $oauth = ['action' => 'bind', 'state' => $state, 'member_id' => $member_id];
        // 设置会话
        $this->session->put('oauth', $oauth);
        return $auth_url;
    }

    /**
     * 取消谷歌绑定
     * @param int $member_id
     * @return ResultService
     */
    public function google_unbind(int $member_id): ResultService
    {
        // 获取授权信息
        $oauth = $this->model->where('member_id', $member_id)->first();
        if (is_null($oauth)) {
            return ResultService::failure('Authorization information not found for the member.');
        }
        // 判断是否绑定谷歌
        if (empty($oauth->google_id)) {
            return ResultService::failure('You have not yet linked your Google services.');
        }
        // 清除谷歌服务
        $oauth->google_id = null;
        if (!$oauth->save()) {
            return ResultService::failure('Unbinding Google services failed, please try again later.');
        }
        // 删除授权信息缓存
        $this->redis->del("member_oauth_info:{$member_id}");
        // 返回
        return ResultService::success("Google service cancellation successful.");
    }
}
