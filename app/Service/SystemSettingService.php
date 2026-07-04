<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\SystemSetting;

class SystemSettingService extends AbstractService
{
    public function __construct()
    {
        $this->model = new SystemSetting();
    }

    /**
     * 根据Key获取系统设置项
     * @param string $key
     * @return mixed
     */
    public function getSettingByKey(string $key): mixed
    {
        $cache_key = "system_setting:{$key}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        // 从数据库获取设置项
        $systemSetting = SystemSetting::where('key', $key)->first();
        // 将设置项缓存起来，过期时间为1小时
        $this->redis->set($cache_key, 300, $systemSetting->value);
        // 返回设置项的值
        return $systemSetting->value;
    }
}
