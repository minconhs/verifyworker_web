<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\TaskType;

class TaskTypeService extends AbstractService
{
    public function __construct()
    {
        $this->model = new TaskType();
    }

    /**
     * 获取任务类型信息
     * @param string $code
     * @return TaskType
     */
    public function getTaskTypeByCode(string $code) : TaskType
    {
        $cache_key = "task_type_info:{$code}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return (new TaskType())->forceFill(json_decode($cache_value, true));
        }
        // 查询数据库获取任务类型
        $task_type = $this->model->where('code', $code)->where('status', 1)->first();
        // 将数据缓存到redis保存120秒
        $this->redis->set($cache_key, 120, $task_type->toJson());
        // 返回任务类型
        return $task_type;
    }
}
