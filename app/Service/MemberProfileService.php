<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\MemberProfile;

class MemberProfileService extends AbstractService
{
    public function __construct()
    {
        $this->model = new MemberProfile();
    }

    /**
     * 获取资料信息
     * @param int $member_id 会员ID
     * @return MemberProfile 会员资料信息
     */
    public function getProfileInfo(int $member_id): MemberProfile
    {
        $cache_key = "member_profile_info:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $this->model->forceFill(json_decode($cache_value, true));
        }
        // 数据库查询会员资料信息
        $profile = $this->model->where('member_id', $member_id)->first();
        // 缓存会员资料信息，设置过期时间为300秒
        $this->redis->set($cache_key, 300, $profile->toJson());
        // 返回会员资料信息
        return $profile;
    }

    /**
     * 更新个人信息
     * @param int $member_id
     * @param array $data
     * @return ResultService
     */
    public function updateProfileInfo(int $member_id, array $data) : ResultService
    {
        $profile = MemberProfile::where('member_id', $member_id)->first();
        if (is_null($profile)) {
            return ResultService::failure('Profile not found. Please contact support.');
        }
        // 填充数据
        $profile->forceFill($data);
        // 保存数据
        if (!$profile->save()) {
            return ResultService::failure('Failed to update profile. Please contact support.');
        }
        // 更新缓存
        $this->redis->del("member_profile_info:{$member_id}");
        // 返回成功结果
        return ResultService::success('Profile updated successfully.');
    }
}
