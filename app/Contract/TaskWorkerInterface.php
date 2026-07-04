<?php

namespace App\Contract;

use App\Model\TaskWorker;

interface TaskWorkerInterface
{
    /**
     * 创建任务
     * @param string $image_id
     * @param string $order_no
     * @return array
     */
    public function create(string $image_id, string $order_no): array;

    /**
     * 验证
     * @param TaskWorker $task
     * @param string $result
     * @return bool
     */
    public function validate(TaskWorker $task, string $result): bool;
}