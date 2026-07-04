<?php

declare(strict_types=1);

namespace App\Service;

use App\Amqp\Producer\TaskOrderCreateProducer;
use App\Model\TaskOrder;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;

class TaskOrderService extends AbstractService
{
    public function __construct()
    {
        $this->model = new TaskOrder();
    }
    
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    #[Inject]
    protected TaskWorkerStatsService $taskWorkerStatsService;

    /**
     * 创建订单 - 员工任务
     * @param int $member_id 会员ID
     * @param string $task_type 任务类型
     * @return ResultService
     */
    public function task_worker_create(int $member_id, string $task_type): ResultService
    {
        // 获取系统是否允许创建订单,为开启不给创建订单
        $task_create_enabled = $this->systemSettingService->getSettingByKey('task_create_enabled');
        if (!$task_create_enabled) {
            return ResultService::failure("There are currently insufficient tasks to create new orders.");
        }

        // 获取每日收入最高上限,超过后不给创建订单
        $task_daily_income_limit = $this->systemSettingService->getSettingByKey('task_daily_income_limit');
        if ($task_daily_income_limit > 0) {
            // 获取当日的收入
            $total_amount = $this->taskWorkerStatsService->getTaskIncome($member_id);
            if ($total_amount >= (float)$task_daily_income_limit) {
                return ResultService::failure("You have reached your daily task limit. Please wait for the cooldown period until tomorrow.");
            }
        }

        // 获取每日任务限制,超过限制不给创建订单
        $task_daily_limit = $this->systemSettingService->getSettingByKey('task_daily_limit');
        if ($task_daily_limit > 0) {
            // 获取当日的任务数量
            $total_count = $this->taskWorkerStatsService->getTaskStatusCount($member_id, 'total');
            if ($total_count >= $task_daily_limit) {
                return ResultService::failure("You have reached your daily task limit. Please wait for the cooldown period until tomorrow.");
            }
        }

        // 获取每日任务成功率限制,低于限制不给创建订单
        $task_daily_success_rate = $this->systemSettingService->getSettingByKey('task_daily_success_rate');
        // 每次任务检测任务数量
        $task_daily_check_count = $this->systemSettingService->getSettingByKey('task_daily_check_count');
        if ($task_daily_success_rate > 0 && $task_daily_check_count > 0) {
            // 获取当日的任务数量
            $total_count = $this->taskWorkerStatsService->getTaskStatusCount($member_id, 'total');
            if ($total_count >= $task_daily_check_count) {
                // 获取当日的成功率
                $today_success_rate = $this->taskWorkerStatsService->getTaskSuccessRate($member_id);
                if ($today_success_rate < (float)$task_daily_success_rate) {
                    return ResultService::failure("The success rate of the current task has reached our limit; you have been restricted.");
                }
            }
        }

        // 定义任务订单标记
        $task_worker_mark_cache_key = "task_worker_mark:{$member_id}";
        // 查询用户是否已经有任务标记,如果有任务标记直接返回旧的订单号,如果没有任务标记则创建新的订单号
        $task_worker_mark_value = $this->redis->get($task_worker_mark_cache_key);
        if ($task_worker_mark_value) {
            return ResultService::success("Order created successfully.", ['order_no' => $task_worker_mark_value]);
        }

        // 生成订单号
        $order_no = date('YmdHis') . str_pad((string)$member_id, 8, '0', STR_PAD_LEFT) . mt_rand(1000, 9999);

        // 存订单号状态到缓存中,供查询订单接口使用
        $set_task_status = $this->redis->set("task_worker_status:{$order_no}", 120, "1");
        if (!$set_task_status) {
            return ResultService::failure('Failed to create order, please try again later.');
        }

        // 存任务订单标记
        $set_task_worker_mark = $this->redis->set($task_worker_mark_cache_key,120, $order_no);
        if (!$set_task_worker_mark) {
            return ResultService::failure('Failed to create order, please try again later.');
        }

        // 准备队列数据，直接使用数组，无需序列化
        $queue_data = ['member_id' => $member_id, 'order_no' => $order_no, 'platform' => 'worker', 'task_type' => $task_type];

        // 获取任务订单队列创建生产者
        $taskOrderProducer = new TaskOrderCreateProducer($queue_data);

        // 发送到队列，无需序列化，直接发送数组
        $send_queue_bool = $this->producer->produce($taskOrderProducer);
        
        if (!$send_queue_bool) {
            return ResultService::failure('Failed to create order, please try again later.');
        }
        // 返回订单创建成功结果
        return ResultService::success("Order created successfully.", [
            'order_no' => $order_no,
        ]);
    }
}
