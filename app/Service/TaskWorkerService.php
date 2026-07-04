<?php

declare(strict_types=1);

namespace App\Service;

use App\Amqp\Producer\TaskWorkerCancelProducer;
use App\Amqp\Producer\TaskWorkerCompleteProducer;
use App\Amqp\Producer\TaskWorkerFailedProducer;
use App\Factory\TaskWorkerFactory;
use App\Model\TaskOrder;
use App\Model\TaskWorker;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;

class TaskWorkerService extends AbstractService
{
    #[Inject]
    protected Producer $producer;

    public function __construct()
    {
        $this->model = new TaskWorker();
    }

    /**
     * 查询订单
     * @param int $member_id 会员ID
     * @param string $order_no 订单编号
     * @return ResultService
     */
    public function query(int $member_id, string $order_no): ResultService
    {
        // 定义订单号状态键
        $task_worker_status_cache_key = "task_worker_status:{$order_no}";
        // 查询订单号状态
        $task_worker_status = $this->redis->get($task_worker_status_cache_key);
        // 如果查询到订单号状态就直接返回状态信息
        if($task_worker_status) {
            return ResultService::success("Query successful", ['status' => (int)$task_worker_status]);
        }
        // 如果没有在Redis中没有查询到订单号状态,继续查询数据库中是否有
        $task_order = TaskOrder::where('member_id', $member_id)->where('order_no', $order_no)->first();
        if (!$task_order) {
            return ResultService::failure('Query successful, task does not exist.');
        }
        // 数据库中有数据,重写到到Redis中
        $set_task_worker_status = $this->redis->set($task_worker_status_cache_key, 120, (string)$task_order->status);
        if (!$set_task_worker_status) {
            return ResultService::failure('The query was successful, but the cache write-back failed.');
        }
        // 返回结果
        return ResultService::success("Query successful", ['status' => $task_order->status]);
    }

    /**
     * 获取订单
     * @param int $member_id 会员ID
     * @param string $order_no 订单编号
     * @return ResultService
     */
    public function fetch(int $member_id, string $order_no): ResultService
    {
        $task_worker_info_cache_key = "task_worker_info:{$order_no}";
        $task_worker_info = $this->redis->get($task_worker_info_cache_key);
        if (!$task_worker_info) {
            return ResultService::failure('Task order not found, please create a new one.');
        }
        // 解析
        $task_worker_info = json_decode($task_worker_info, true);
        // 检查订单是否所属当前会员
        if ($task_worker_info['member_id'] !== $member_id) {
            return ResultService::failure('Task order not found, please create a new one.');
        }
        // 获取到期时间
        $expired_at = strtotime($task_worker_info['expired_at']);
        // 计算剩余时间
        $remaining_time = $expired_at - time();
        // 获取payload
        $payload = json_decode($task_worker_info['payload'], true);
        // 组装订单数据
        $payload['left_time'] = max($remaining_time, 0);
        // 返回订单数据
        return ResultService::success("Task fetched successfully", $payload);
    }

    /**
     * 提交订单
     * @param int $member_id
     * @param string $order_no
     * @param string $result
     * @return ResultService
     */
    public function submit(int $member_id, string $order_no, string $result): ResultService
    {
        $task_worker_info_cache_key = "task_worker_info:{$order_no}";
        $task_worker_info = $this->redis->get($task_worker_info_cache_key);
        if (!$task_worker_info) {
            return ResultService::failure('Task order not found, please create a new one.');
        }
        // 解析
        $task_worker_info = json_decode($task_worker_info, true);
        // 检查订单是否所属当前会员
        if ($task_worker_info['member_id'] !== $member_id) {
            return ResultService::failure('Task order not found, please create a new one.');
        }
        // 设置提交结果
        $task_worker_info['result'] = $result;

        $payload = json_decode($task_worker_info['payload'], true);

        // 验证答案
        $validate = TaskWorkerFactory::create($payload['type'])->validate((new TaskWorker)->forceFill($task_worker_info), $result);
        // 根据答案结果定义要发送到的队列
        if($validate) {
            $queue = new TaskWorkerCompleteProducer($task_worker_info);
        } else {
            $queue = new TaskWorkerFailedProducer($task_worker_info);
        }
        // 推送到提交队列
        $push_queue_bool = $this->producer->produce($queue);
        if (!$push_queue_bool) {
            return ResultService::failure('Task submission failed, please try again later.');
        }

        // 删除订单相关的缓存数据
        $this->redis->pipeline(function ($pipe) use ($member_id, $order_no, $task_worker_info) {
            // 删除用户订单标记
            $pipe->del("task_worker_mark:{$member_id}");
            // 删除订单状态
            $pipe->del("task_worker_status:{$order_no}");
            // 删除订单缓存
            $pipe->del("task_worker_info:{$order_no}");
            // 删除订单过期
            $pipe->zRem("task_worker_expire", $order_no);
        });

        return ResultService::success('Task submitted successfully, please wait for the result to be processed.');
    }

    /**
     * 取消订单
     * @param int $member_id
     * @param string $order_no
     * @return ResultService
     */
    public function cancel(int $member_id, string $order_no): ResultService
    {
        $task_worker_order_info_cache_key = "task_worker_info:{$order_no}";
        $task_worker_order_info = $this->redis->get($task_worker_order_info_cache_key);
        if (!$task_worker_order_info) {
            return ResultService::failure('Task order not found, please create a new one.');
        }
        // 解析
        $task_worker_order_info = json_decode($task_worker_order_info, true);
        // 检查订单是否所属当前会员
        if ($task_worker_order_info['member_id'] !== $member_id) {
            return ResultService::failure('Task order not found, please create a new one.');
        }

        $queue = new TaskWorkerCancelProducer($task_worker_order_info);
        // 推送到提交队列
        $push_queue_bool = $this->producer->produce($queue);
        if (!$push_queue_bool) {
            return ResultService::failure('Task cancel failed, please try again later.');
        }

        // 删除订单相关的缓存数据
        $this->redis->pipeline(function ($pipe) use ($member_id, $order_no, $task_worker_order_info) {
            // 删除用户订单标记
            $pipe->del("task_worker_mark:{$member_id}");
            // 删除订单状态
            $pipe->del("task_worker_status:{$order_no}");
            // 删除订单缓存
            $pipe->del("task_worker_info:{$order_no}");
            // 删除订单过期
            $pipe->zRem("task_worker_expire", $order_no);
        });

        return ResultService::success('Task submitted successfully, please wait for the result to be processed.');
    }

    /**
     * 获取图片
     * @param string $image_id
     * @return ResultService
     */
    public function image(string $image_id): ResultService
    {
        $cache_key = "task_worker_image:{$image_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return ResultService::success("Image fetch successful", $cache_value);
        }
        return ResultService::failure("Image retrieval failed");
    }
}
