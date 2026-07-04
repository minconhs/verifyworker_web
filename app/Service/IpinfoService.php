<?php

namespace App\Service;

use Hyperf\Di\Annotation\Inject;
use ipinfo\ipinfo\IPinfo;
use ipinfo\ipinfo\IPinfoException;

class IpinfoService
{
    protected IPinfo $ipInfo;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    /**
     * 获取IP地址的地理位置信息（包含国家、城市、地区等）
     * @param string $ip_address
     * @return string|null
     */
    public function getLocation(string $ip_address): ?string
    {
        try {
            // 获取IP——info 密钥
            $other_ipinfo_key = $this->systemSettingService->getSettingByKey('other_ipinfo_key');

            $this->ipInfo = new IPinfo($other_ipinfo_key);

            $details = $this->ipInfo->getDetails($ip_address);
            $location = "";
            if ($details->country_flag && isset($details->country_flag['emoji'])) {
                $location .= $details->country_flag['emoji'] . ' ';
            }
            if (isset($details->city)) {
                $location .= $details->city . ' ';
            }
            if (isset($details->region)) {
                $location .= $details->region . ' ';
            }
            if (isset($details->country)) {
                $location .= "," . $details->country;
            }
            if (empty($location)) {
                return '🏳️ Unknown location';
            }
            return trim($location);
        } catch (IPinfoException $e) {
            return 'Unknown location';
        }
    }
}