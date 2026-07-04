<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\MemberSetting;

class MemberSettingService extends AbstractService
{
    public function __construct()
    {
        $this->model = new MemberSetting();
    }

    /**
     * 获取会员设置
     * @param int $member_id
     * @return MemberSetting
     */
    public function getMemberSettingInfo(int $member_id) : MemberSetting
    {
        $cache_key = "member_setting_info:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $this->model->forceFill(json_decode($cache_value, true));
        }
        // 缓存不存在，查询数据库
        $setting = $this->model->where('member_id', $member_id)->first();
        // 缓存数据库结果
        $this->redis->set($cache_key, 300, $setting->toJson());
        // 返回会员设置
        return $setting;
    }

    /**
     * 更新会员设置
     * @param int $member_id 会员ID
     * @param array $data 更新数据
     * @return ResultService
     */
    public function updateMemberSettingInfo(int $member_id, array $data): ResultService
    {
        $settings = $this->model->where('member_id', $member_id)->first();
        if (is_null($settings)) {
            return ResultService::failure('Notification settings not found');
        }
        // 填充数据
        $settings->forceFill($data);
        // 保存设置
        $settings->save();
        // 更新缓存
        $this->redis->set("member_setting_info:{$member_id}", 300, $settings->toJson());

        return ResultService::success("Settings updated successfully");
    }
}
