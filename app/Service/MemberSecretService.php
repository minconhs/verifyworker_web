<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\MemberSecret;
use Hyperf\Stringable\Str;

class MemberSecretService extends AbstractService
{
    public function __construct()
    {
        $this->model = new MemberSecret();
    }

    /**
     * 创建会员密钥
     * @param int $member_id 会员ID
     * @param string $hook_url 回调地址
     * @param string $white_ip 白名单IP
     * @param string $remark 备注
     */
    public function create(int $member_id, string $hook_url, string $white_ip, string $remark): ResultService
    {
        // 检查密钥数量限制
        $secret_count = $this->model->where('member_id', $member_id)->count();
        if ($secret_count >= 30) {
            return ResultService::failure('You can only create up to 30 API secrets');
        }

        // 创建密钥记录
        $secret = new MemberSecret();
        $secret->member_id = $member_id;
        $secret->code = "sk_".bin2hex(Str::random());
        $secret->hook_url = $hook_url;
        if (!empty($white_ip)) {
            $secret->white_ip = $white_ip;
        }
        if (!empty($remark)) {
            $secret->remark = $remark;
        }
        if (!$secret->save()) {
            return ResultService::failure('Failed to create API secret');
        }
        return ResultService::success('API secret created successfully');
    }

    /**
     * 删除会员密钥
     * @param int $member_id 会员ID
     * @param int $secret_id 密钥ID
     * @return ResultService
     */
    public function delete(int $member_id, int $secret_id): ResultService
    {
        // 查找密钥记录
        $secret = $this->model->where('id', $secret_id)->where('member_id', $member_id)->first();
        if (is_null($secret)) {
            return ResultService:: failure('API key not found');
        }

        // 删除密钥记录
        if (!$secret->delete()) {
            return ResultService:: failure('Failed to delete API key');
        }

        return ResultService::success('API key successfully deleted.');
    }
}
