<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\TaskWorkerStat;
use Carbon\Carbon;
use Hyperf\Collection\Collection;

class TaskWorkerStatsService extends AbstractService
{
    public function __construct()
    {
        $this->model = new TaskWorkerStat();
    }

    /**
     * 获取某天统计信息
     * @param int $member_id 会员ID
     * @param string|null $date 统计日期
     * @return Collection
     */
    public function getTaskStatsInfo(int $member_id, string $date = null): Collection
    {
        // 如果没有传日期参数,日期默认当日
        if ($date == null) {
            $date = date('Y-m-d');
        }
        $cache_key = "task_worker_stats_info:{$member_id}:{$date}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return Collection::make(json_decode($cache_value, true));
        }
        // 查询数据库
        $workerStats = $this->model->where('member_id', $member_id)->whereDate('date', $date)->get();
        // 将结果缓存到Redis，设置过期时间为60秒
        $this->redis->set($cache_key, 60, $workerStats->toJson());
        // 返回结果
        return $workerStats;
    }

    /**
     * 获取全部统计信息
     * @param int $member_id 会员ID
     * @return Collection
     */
    public function getAllTaskStatsInfo(int $member_id): Collection
    {
        // 定义当前时间
        $current_date = Carbon::now();
        // 定义月初时间
        $startOf_month = $current_date->copy()->startOfMonth();
        // 定义月底时间
        $endOf_month = $current_date->copy()->endOfMonth();
        $cache_key = "task_worker_stats_info:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return Collection::make(json_decode($cache_value, true));
        }
        // 查询数据库,当月的数据
        $workerStats = $this->model->where('member_id', $member_id)->whereBetween('created_at', [$startOf_month, $endOf_month])->get();
        // 将结果缓存到Redis，设置过期时间为120秒
        $this->redis->set($cache_key, 120, $workerStats->toJson());
        // 返回结果
        return $workerStats;
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
    public function getAllTaskSuccessRate(int $member_id): float
    {
        // 获取统计数据
        $task_stats_info = $this->getAllTaskStatsInfo($member_id);
        // 获取全部的数量
        $completed_count = $task_stats_info->sum('completed');
        // 获取统计数量
        $total_count = $task_stats_info->sum('total');
        // 获取百分比
        return $total_count > 0 ? round(($completed_count / $total_count) * 100, 2) : 0;
    }

    /**
     * 获取某天任务成功率
     * @param int $member_id
     * @return float
     */
    public function getTaskSuccessRate(int $member_id): float
    {
        // 获取统计数据
        $task_stats_info = $this->getTaskStatsInfo($member_id);
        // 获取成功的数量
        $completed_count = $task_stats_info->sum('completed');
        // 获取统计数量
        $total_count = $task_stats_info->sum('total');
        // 获取百分比
        return $total_count > 0 ? round(($completed_count / $total_count) * 100, 2) : 0;
    }

    /**
     * 获取当天任务收入
     * @param int $member_id
     * @return float
     */
    public function getTaskIncome(int $member_id): float
    {
        // 获取统计数据
        $task_stats_info = $this->getTaskStatsInfo($member_id);
        // 获取全部的统计金额
        return $task_stats_info->sum('total_amount');
    }

    /**
     * 一周统计
     * @param int $member_id
     * @return array
     */
    public function getTaskWeekStats(int $member_id): array
    {
        // 定义当前时间
        $current_date = Carbon::now();
        // 定义这周开始时间
        $this_start_week = $current_date->copy()->subDays(7)->startOfDay()->toDateTimeString();
        // 定义这周结束时间
        $this_end_week = $current_date->copy()->subDay()->endOfDay()->toDateTimeString();
        // 获取本周统计数据
        $this_worker_stats = $this->model->where('member_id', $member_id)->whereBetween('created_at', [$this_start_week, $this_end_week])->get();
        // 获取本周的总统计次数
        $this_worker_stats_total = $this_worker_stats->sum('total');


        // 定义上周开始时间
        $last_start_week = $current_date->copy()->subDays(14)->startOfDay()->toDateTimeString();
        // 定义上周结束时间
        $last_end_week = $current_date->copy()->subDays(8)->endOfDay()->toDateTimeString();
        // 获取上周统计数据
        $last_worker_stats = $this->model->where('member_id', $member_id)->whereBetween('created_at', [$last_start_week, $last_end_week])->get();
        // 获取上周的总统计次数
        $last_worker_stats_total = $last_worker_stats->sum('total');


        // +10.2% vs last week
        $growth_rate = $last_worker_stats_total > 0 ? round(($this_worker_stats_total - $last_worker_stats_total) / $last_worker_stats_total * 100, 2) : 0;
        $week_stats_desc = "{$growth_rate}% vs last week";

        // 获取本周完成的统计次数
        $this_worker_stats_completed =  $this_worker_stats->isNotEmpty() ? $this_worker_stats->sum('completed') : 0;
        // 获取完成的占有率
        $this_worker_stats_completed_rate = $this_worker_stats_total > 0 ? round(($this_worker_stats_completed / $this_worker_stats_total) * 100, 2) : 0;

        //  获取本周失败的统计次数
        $this_worker_stats_failed =  $this_worker_stats->isNotEmpty() ? $this_worker_stats->sum('failed') : 0;
        //  获取本周超时的统计次数
        $this_worker_stats_timeout =  $this_worker_stats->isNotEmpty() ? $this_worker_stats->sum('timeout') : 0;
        // 本周失败与超时统计合并
        $this_worker_stats_failed = $this_worker_stats_failed + $this_worker_stats_timeout;
        // 获取失败的占有率
        $this_worker_stats_failed_rate = $this_worker_stats_total > 0 ? round(($this_worker_stats_failed / $this_worker_stats_total) * 100, 2) : 0;

        // 获取本周取消的统计次数
        $this_worker_stats_cancel =  $this_worker_stats->isNotEmpty() ? $this_worker_stats->sum('cancel') : 0;
        // 获取取消的占有率
        $this_worker_stats_cancel_rate = $this_worker_stats_total > 0 ? round(($this_worker_stats_cancel / $this_worker_stats_total) * 100, 2) : 0;


        return [
            'this_worker_stats_total' => $this_worker_stats_total,
            'week_stats_desc' => $week_stats_desc,
            'this_worker_stats_completed' => $this_worker_stats_completed,
            'this_worker_stats_completed_rate' => $this_worker_stats_completed_rate,
            'this_worker_stats_failed' => $this_worker_stats_failed,
            'this_worker_stats_failed_rate' => $this_worker_stats_failed_rate,
            'this_worker_stats_cancel' => $this_worker_stats_cancel,
            'this_worker_stats_cancel_rate' => $this_worker_stats_cancel_rate,
        ];
    }

    /**
     * 获取图表数据
     * @param int $member_id
     * @return string
     */
    public function chart(int $member_id) : string
    {
        $redis_key = "task_worker_chart_data:{$member_id}";
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
