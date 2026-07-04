<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\TaskClientStat;
use Carbon\Carbon;
use Hyperf\Collection\Collection;

class TaskClientStatsService extends AbstractService
{
    public function __construct()
    {
        $this->model = new TaskClientStat();
    }

    /**
     * 获取统计信息
     * @param int $member_id 会员ID
     * @return Collection
     */
    public function getTaskStatsInfo(int $member_id): Collection
    {
        // 定义当前时间
        $current_date = Carbon::now();
        // 定义月初时间
        $startOf_month = $current_date->copy()->startOfMonth();
        // 定义月底时间
        $endOf_month = $current_date->copy()->endOfMonth();
        $cache_key = "task_client_stats_info:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return Collection::make(json_decode($cache_value, true));
        }
        // 查询数据库,当月的数据
        $clientStats = $this->model->where('member_id', $member_id)->whereBetween('created_at', [$startOf_month, $endOf_month])->get();
        // 将结果缓存到Redis，设置过期时间为120秒
        $this->redis->set($cache_key, 120, $clientStats->toJson());
        // 返回结果
        return $clientStats;
    }

    /**
     * 获取状态数量
     * @param int $member_id
     * @param string $field
     * @return mixed
     */
    public function getTaskStatusCount(int $member_id, string $field): mixed
    {
        // 获取统计数据
        $task_stats_info = $this->getTaskStatsInfo($member_id);
        // 获取任务数量
        return $task_stats_info->sum($field);
    }

    /**
     * 获取全部任务成功率
     * @param int $member_id
     * @return float
     */
    public function getTaskSuccessRate(int $member_id): float
    {
        // 获取统计数据
        $task_stats_info = $this->getTaskStatsInfo($member_id);
        // 获取全部的数量
        $completed_count = $task_stats_info->sum('completed');
        // 获取统计数量
        $total_count = $task_stats_info->sum('total');
        // 获取百分比
        return $total_count > 0 ? round(($completed_count / $total_count) * 100, 2) : 0;
    }

    /**
     * 获取本月任务支出
     * @param int $member_id
     * @return float
     */
    public function getMonthTaskExpend(int $member_id): float
    {
        // 获取统计数据
        $task_stats_info = $this->getTaskStatsInfo($member_id);
        // 获取全部的统计金额
        return $task_stats_info->sum('total_amount');
    }

    /**
     * 获取图表数据
     * @param int $member_id
     * @return string
     */
    public function chart(int $member_id) : string
    {
        $redis_key = "task_client_chart_data:{$member_id}";
        $redis_data = $this->redis->get($redis_key);
        if ($redis_data) {
            return $redis_data;
        }
        // 定义标签和数据集
        $labels = [];
        // 定义数据集，包含completed、cancel、failed三个数据集
        $datasets = [];
        // 定义completed
        $completed = [
            'label' => 'Completed',
            'data' => [],
            'borderColor' => 'rgb(6,182,212)',
            'backgroundColor' => 'rgba(6,182,212, 0.1)',
            'borderWidth' => 2,
            'pointRadius' => 3,
            'tension' => 0.4,
            'fill' => true
        ];
        // 定义cancel
        $cancel = [
            'label' => 'Cancel',
            'data' => [],
            'borderColor' => 'rgb(251, 191, 36)',
            'backgroundColor' => 'rgba(251, 191, 36, 0.1)',
            'borderWidth' => 2,
            'pointRadius' => 3,
            'tension' => 0.4,
            'fill' => true
        ];
        // 定义failed
        $failed = [
            'label' => 'Failed',
            'data' => [],
            'borderColor' => 'rgb(248, 113, 113)',
            'backgroundColor' => 'rgba(248, 113, 113, 0.1)',
            'borderWidth' => 2,
            'pointRadius' => 3,
            'tension' => 0.4,
            'fill' => true
        ];
        // 定义当前时间
        $current_time = Carbon::now();

        // 定义上一周的时间范围
        $last_start_of_week = $current_time->copy()->subDays(8)->toDateString();
        $last_end_of_week   = $current_time->copy()->subDay()->toDateString();

        // 查询7天内的统计数据
        $all_stats_info = $this->model->where('member_id', $member_id)->whereBetween('created_at', [$last_start_of_week, $last_end_of_week])->get();

        // 生成过去7天的日期标签
        for ($i = 7; $i > 0; $i--) {
            $date = $current_time->copy()->subDays($i)->toDateString();
            $date_label = $current_time->copy()->subDays($i)->isoFormat('MMM DD');
            $labels[] = $date_label;
            // 查询完成的
            $stats_completed = $all_stats_info->where('date', $date)->sum('completed');
            // 查询取消的
            $stats_cancel = $all_stats_info->where('date', $date)->sum('cancel');
            // 查询失败的
            $stats_failed = $all_stats_info->where('date', $date)->sum('failed');
            // 查询超时的
            $stats_timeout = $all_stats_info->where('date', $date)->sum('timeout');

            $completed['data'][] = $stats_completed;
            $cancel['data'][] = $stats_cancel;
            $failed['data'][] = $stats_failed + $stats_timeout;
        }
        $datasets[] = $completed;
        $datasets[] = $cancel;
        $datasets[] = $failed;

        // 合并标签和数据集
        $chart_data = [
            'labels' => $labels,
            'datasets' => $datasets
        ];
        // 缓存图表数据，过期时间为120秒
        $this->redis->set($redis_key, 120, json_encode($chart_data));
        // 返回图表数据
        return json_encode($chart_data);
    }
}
