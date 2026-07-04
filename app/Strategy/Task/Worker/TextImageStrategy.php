<?php

namespace App\Strategy\Task\Worker;

use App\Contract\TaskWorkerInterface;
use App\Exception\BusinessException;
use App\Model\TaskWorker;
use App\Service\RedisService;
use Hyperf\Di\Annotation\Inject;
use Olakunlevpn\Captcha\Captcha;
use Psr\Log\LoggerInterface;

class TextImageStrategy implements TaskWorkerInterface
{
    #[Inject]
    protected Captcha $captcha;

    #[Inject]
    protected RedisService $redis;

    #[Inject]
    protected LoggerInterface $logger;

    /**
     * @inheritDoc
     */
    public function create(string $image_id, string $order_no): array
    {
        try {
            // 设置字体路径
            $this->captcha->setFont(BASE_PATH . '/public/assets/fonts');
            // 设置文本颜色为黑色
            $this->captcha->setTextColor(0, 0, 0);
            // 设置背景颜色为白色
            $this->captcha->setBackgroundColor(255, 255, 255);
            // 设置验证码长度为4
            $this->captcha->setLength(4);
            // 设置验证码类型为默认
            $this->captcha->setType('mixed');
            // 切换点状噪声并设置数量。
            $this->captcha->setNoise(true,10);
            // 切换线条干扰并设置数量。
            $this->captcha->setLines(true,10);
            // 切换波形扭曲并设置振幅和周期。
            $this->captcha->setDistortion(true, 5, 10);
            // 生成验证码
            $this->captcha->create();
            // 获取验证码文本
            $captcha_text = $this->captcha->getCode();
            // 获取Base64编码的图片数据
            $image_base64 = str_replace('data:image/png;base64,', '', $this->captcha->getBase64());
            // 将Base64编码的图片数据转换为二进制数据
            $image_data   = base64_decode($image_base64);
            // 缓存验证码数据,设置过期时间为2分钟
            $this->redis->set("task_worker_image:{$image_id}", 120, $image_data);
            // 生成任务参数
            $payload = [
                'type' => 'image_text',
                'image' => '/task/worker/image/' . $image_id,
                'min_length' => mt_rand(0, 100) > 80 ? strlen($captcha_text) : 3,
                'max_length' => 8,
                'case_sensitive' => mt_rand(0, 100) > 80,
                'tips_message' => 'Please enter the characters you see in the image',
                'order_no' => $order_no,
            ];
            return [
                'payload' => $payload,
                'result'  => $this->captcha->getCode(),
            ];
        } catch (\Throwable $e) {
            $this->logger->error("生成文本图片验证码失败: " . $e->getMessage());
            throw new BusinessException("Get text image captcha failed" );
        }
    }

    /**
     * @inheritDoc
     */
    public function validate(TaskWorker $task, string $result): bool
    {
        return strtolower($result) === strtolower($task->answer);
    }
}