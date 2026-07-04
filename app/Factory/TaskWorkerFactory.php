<?php

declare(strict_types=1);

namespace App\Factory;

use App\Contract\TaskWorkerInterface;
use App\Strategy\Task\Worker\ClickImageStrategy;
use App\Strategy\Task\Worker\MathImageStrategy;
use App\Strategy\Task\Worker\TextImageStrategy;
use App\Strategy\Task\Worker\TurnstileStrategy;
use function Hyperf\Support\make;

class TaskWorkerFactory
{
    /**
     * 创建工厂实例
     * @param string $type
     * @return TaskWorkerInterface
     */
    public static function create(string $type): TaskWorkerInterface
    {
        return match ($type) {
            'image_click' => make(ClickImageStrategy::class),
            'image_math' => make(MathImageStrategy::class),
            'image_text' => make(TextImageStrategy::class),
            'turnstile' => make(TurnstileStrategy::class)
        };
    }
}