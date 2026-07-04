<?php

declare(strict_types=1);

namespace App\Strategy\Task\Worker;

use App\Contract\TaskWorkerInterface;
use App\Exception\BusinessException;
use App\Model\TaskWorker;
use App\Service\RedisService;
use Hyperf\Di\Annotation\Inject;
use Petalbranch\IconCaptcha\IconCaptcha;
use Psr\Log\LoggerInterface;

class ClickImageStrategy implements TaskWorkerInterface
{

    #[Inject]
    protected IconCaptcha $captcha;

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
            // 生成验证码
            $captcha = $this->captcha->generate();
            // 获取验证码图标
            $captcha_icons = $captcha['icons'];
            // 获取验证码图片
            $captcha_image = $captcha['image'];
            // 获取验证码答案
            $captcha_answer = $captcha['answer'];
            // 缓存验证码数据,设置过期时间为2分钟
            $this->redis->set("task_worker_image:{$image_id}", 120, base64_decode($captcha_image));
            // 缓存小图标数据,设置过期时间为2分钟
            foreach ($captcha_icons as $index => $icon) {
                $icon_image_id = $image_id . '_' . $index;
                $this->redis->set("task_worker_image:{$icon_image_id}", 120, base64_decode($icon));
                $captcha_icons[$index] = '/task/worker/image/' . $icon_image_id;
            }

            // 生成任务参数
            $payload = [
                'type' => 'image_click',
                'image' => '/task/worker/image/' . $image_id,
                'icons' => $captcha_icons,
                'tips_message' => 'Please click on the specified points in the image',
                'order_no' => $order_no,
            ];
            return [
                'payload' => $payload,
                'result' => json_encode($captcha_answer),
            ];
        } catch (\Throwable $e) {
            $this->logger->error("生成图片点击验证码失败: " . $e->getMessage());
            throw new BusinessException("Get click image captcha failed" );
        }
    }

    /**
     * @inheritDoc
     */
    public function validate(TaskWorker $task, string $result): bool
    {
        $result = json_decode($result, true);
        return $this->captcha->verify($result, json_decode($task->answer, true));
    }
}