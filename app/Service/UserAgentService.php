<?php

namespace App\Service;

use DeviceDetector\DeviceDetector;
use Hyperf\Di\Annotation\Inject;

class UserAgentService
{
    #[Inject]
    protected DeviceDetector $deviceDetector;

    /**
     * 解析用户代理字符串，获取操作系统
     * @param string $user_agent
     * @return string
     */
    public function getOs(string $user_agent): string
    {
        $this->deviceDetector->setUserAgent($user_agent);
        $this->deviceDetector->parse();
        $os = $this->deviceDetector->getOs('name');
        if (empty($os)) {
            return 'Unknown';
        }
        return $os;
    }

    /**
     * 解析用户代理字符串，获取浏览器信息
     * @param string $user_agent
     * @return string
     */
    public function getBrowser(string $user_agent): string
    {
        $this->deviceDetector->setUserAgent($user_agent);
        $this->deviceDetector->parse();
        $browser = $this->deviceDetector->getClient('name');
        if (empty($browser)) {
            return 'Unknown';
        }
        return $browser;
    }

    /**
     * 解析用户代理字符串，获取设备信息
     * @param string $user_agent
     * @return string
     */
    public function getDevice(string $user_agent): string
    {
        $this->deviceDetector->setUserAgent($user_agent);
        $this->deviceDetector->parse();
        $device = $this->deviceDetector->getDeviceName();
        if (empty($device)) {
            return 'Unknown';
        }
        return $device;
    }
}