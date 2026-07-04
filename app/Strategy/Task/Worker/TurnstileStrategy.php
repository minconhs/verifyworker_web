<?php

namespace App\Strategy\Task\Worker;

use andkab\Turnstile\Turnstile;
use App\Contract\TaskWorkerInterface;
use App\Exception\BusinessException;
use App\Model\TaskWorker;
use App\Service\SystemSettingService;
use Hyperf\Di\Annotation\Inject;
use Psr\Log\LoggerInterface;

class TurnstileStrategy implements TaskWorkerInterface
{
    #[Inject]
    protected SystemSettingService $systemSettingService;

    #[Inject]
    protected LoggerInterface $logger;

    /**
     * @inheritDoc
     */
    public function create(string $image_id, string $order_no): array
    {
        // 获取Turnstile站点密钥
        $captcha_turnstile_site_key = $this->systemSettingService->getSettingByKey('captcha_turnstile_site_key');
        // 生成内部使用的任务答案
        $result = $this->generateFakeTurnstileToken();
        try {
            // 生成任务参数
            $payload = [
                'type' => 'turnstile',
                'site_key' => $captcha_turnstile_site_key,
                'tips_message' => 'Please complete the human-computer interaction verification',
                'order_no' => $order_no,
            ];
            return [
                'payload' => $payload,
                'result' => $result,
            ];
        } catch (\Throwable $e) {
            $this->logger->error("生成Turnstile验证码失败: " . $e->getMessage());
            throw new BusinessException("Get click image captcha failed" );
        }
    }

    /**
     * @inheritDoc
     */
    public function validate(TaskWorker $task, string $result): bool
    {
        // 内部验证,直接比较答案,如果不对再走官方接口验证
        if (strtolower($result) === strtolower($task->answer)) {
            return true;
        }
        // 获取Turnstile站点密钥
        $captcha_turnstile_key = $this->systemSettingService->getSettingByKey('captcha_turnstile_key');
        // 获取客户端
        $turnstileClient = new Turnstile($captcha_turnstile_key);
        // 验证token
        $verifyResponse = $turnstileClient->verify($result);
        // 返回结果
        return $verifyResponse->isSuccess();
    }

    /**
     * 生成 Cloudflare Turnstile Token 格式
     */
    private function generateFakeTurnstileToken(): string {
        // 1. 生成极长的 Base64URL 编码载荷 (模拟环境指纹)
        $payload = rtrim(strtr(base64_encode(random_bytes(350)), '+/', '-_'), '=');

        // 2. 生成中等长度的 Base64URL 编码元数据
        $metadata = rtrim(strtr(base64_encode(random_bytes(18)), '+/', '-_'), '=');

        // 3. 生成 64 位十六进制的签名
        $signature = bin2hex(random_bytes(32));

        // 4. 拼接为 Turnstile 标准的四段式格式
        return '1.' . $payload . '.' . $metadata . '.' . $signature;
    }
}