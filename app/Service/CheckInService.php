<?php

namespace App\Service;

use App\Exception\BusinessException;
use App\Model\MemberCheckin;
use App\Model\MemberCheckinStat;
use Carbon\Carbon;
use Hyperf\Collection\Collection;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class CheckInService extends AbstractService
{
    #[Inject]
    protected CheckinRewardService $checkinRewardService;

    #[Inject]
    protected TaskWorkerStatsService $taskWorkerStatsService;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    public function __construct()
    {
        $this->model = new MemberCheckin();
    }

    /**
     * 获取今日签到奖励
     * @param int $member_id
     * @return string
     */
    public function getTodayCheckinRewardAmount(int $member_id): string
    {
        $cache_key = "today_checkin_reward_amount:{$member_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $cache_value;
        }
        $checkin = $this->model->where('member_id', $member_id)->whereDate('checkin_date', date('Y-m-d'))->first();
        if (is_null($checkin)) {
            $reward_amount = "0.00";
        } else {
            $reward_amount = $checkin->reward_amount;
        }
        $this->redis->set($cache_key, 120, $reward_amount);
        return $reward_amount;
    }

    /**
     * 获取今日成功率
     * @param int $member_id
     * @return float
     */
    public function getTodayTaskWorkerSuccessRate(int $member_id): float
    {
        // 获取今日的任务统计信息
        $statsInfo = $this->taskWorkerStatsService->getTaskStatsInfo($member_id);
        // 获取成功的数量
        $completed_count = $statsInfo->sum('completed');
        // 获取统计数量
        $total_count = $statsInfo->sum('total');
        // 判断获取到的数据是否为0
        if ($completed_count <= 0 || $total_count <= 0) {
            return 0.00;
        }
        // 获取百分比
        return round(($completed_count / $total_count) * 100, 2);
    }

    /**
     * 获取今日任务完成进度
     * @param int $member_id
     * @return int
     */
    public function getTodayTaskCompleted(int $member_id): int
    {
        // 获取签到成功率
        $check_success_rate = $this->systemSettingService->getSettingByKey("check_success_rate");
        // 获取签到图文任务数量
        $check_image_text_count = $this->systemSettingService->getSettingByKey("check_image_text_count");
        // 获取签到图像数学任务数量
        $check_image_math_count = $this->systemSettingService->getSettingByKey("check_image_math_count");
        // 获取签到图片点击任务数量
        $check_image_click_count = $this->systemSettingService->getSettingByKey("check_image_click_count");

        $progress = 0;
        // 获取今日的任务统计信息
        $statsInfo = $this->taskWorkerStatsService->getTaskStatsInfo($member_id);
        if ($statsInfo->isEmpty()) {
            return $progress;
        }
        // 查询今日图文任务数量
        $image_text_count = $statsInfo->where('task_type','image_text')->value('completed');
        if ($image_text_count >= (int)$check_image_text_count) {
            $progress++;
        }
        // 查询今日图像数学任务数量
        $image_math_count = $statsInfo->where('task_type','image_math')->value('completed');
        if ($image_math_count >= (int)$check_image_math_count) {
            $progress++;
        }
        // 查询今日图片点击任务数量
        $image_click_count = $statsInfo->where('task_type','image_click')->value('completed');
        if ($image_click_count >= (int)$check_image_click_count) {
            $progress++;
        }
        // 获取今日成功率
        $success_rate = $this->getTodayTaskWorkerSuccessRate($member_id);
        if ($success_rate >= (int)$check_success_rate) {
            $progress++;
        }
        return $progress;
    }

    /**
     * 获取签到日历
     * @param int $member_id
     * @return array
     */
    public function getCheckInCalendar(int $member_id): array
    {
        // 定义当前时间
        $current_date = Carbon::now();
        // 定义当月开始时间
        $start_of_month = $current_date->copy()->startOfMonth();
        // 定义当月天数
        $days_in_month = $current_date->copy()->daysInMonth;
        // 查询所有的签到记录
        $checkins = MemberCheckin::where('member_id', $member_id)->whereBetween('checkin_date',[$current_date->copy()->startOfMonth(), $current_date->copy()->endOfMonth()])->get()->keyBy('checkin_date');;
        $calendar = [];
        for ($i = 0; $i < $days_in_month; $i++) {
            $date = $start_of_month->copy()->addDays($i)->toDateString();
            $calendar[] = [
                'is_today' => $current_date->copy()->toDateString() == $date,
                'date' => $date,
                'day' => $i + 1,
                'signed' => $checkins->has($date),
                'reward_amount' => $checkins->has($date) ? $checkins->get($date)->reward_amount : "0.00",
            ];

        }
        return $calendar;
    }

    /**
     * 获取今日任务统计
     * @param int $member_id
     * @return array
     */
    public function getTodayTaskStats(int $member_id): array
    {
        // 获取签到成功率
        $check_success_rate = $this->systemSettingService->getSettingByKey("check_success_rate");
        // 获取签到图文任务数量
        $check_image_text_count = $this->systemSettingService->getSettingByKey("check_image_text_count");
        // 获取签到图像数学任务数量
        $check_image_math_count = $this->systemSettingService->getSettingByKey("check_image_math_count");
        // 获取签到图片点击任务数量
        $check_image_click_count = $this->systemSettingService->getSettingByKey("check_image_click_count");

        // 获取今日的任务统计信息
        $statsInfo = $this->taskWorkerStatsService->getTaskStatsInfo($member_id);
        // 查询今日图文任务数量
        $image_text_count = $statsInfo->where('task_type','image_text')->value('completed');
        $stats[] = [
            'progress' => min(100,$image_text_count > 0 ? round(($image_text_count / (int)$check_image_text_count) * 100, 2) : 0),
            'done' => $image_text_count >= (int)$check_image_text_count,
            'title' => "Complete {$check_image_text_count} Image Text Tasks",
            'desc' => "Solve image text challenges"
        ];

        // 查询今日图像数学任务数量
        $image_math_count = $statsInfo->where('task_type','image_math')->value('completed');
        $stats[] = [
            'progress' => min(100,$image_math_count > 0 ? round(($image_math_count / (int)$check_image_math_count) * 100, 2) : 0),
            'done' => $image_math_count >= (int)$check_image_math_count,
            'title' => "Complete {$check_image_math_count} Image Math Tasks",
            'desc' => "Solve math-based image challenges"
        ];

        // 查询今日图片点击任务数量
        $image_click_count = $statsInfo->where('task_type','image_click')->value('completed');
        $stats[] = [
            'progress' => min(100,$image_click_count > 0 ? round(($image_click_count / (int)$check_image_click_count) * 100, 2) : 0),
            'done' => $image_click_count >= (int)$check_image_click_count,
            'title' => "Complete {$check_image_click_count} Image Click Tasks",
            'desc' => "Select correct image regions"
        ];

        // 获取今日成功率
        $success_rate = $this->getTodayTaskWorkerSuccessRate($member_id);
        $stats[] = [
            'progress' => $success_rate,
            'done' => $success_rate >= (int)$check_success_rate,
            'title' =>  "Maintain {$check_success_rate}% Accuracy Rate",
            'desc' => "Current accuracy is {$success_rate}%"
        ];

        // 返回统计数据
        return $stats;
    }

    /**
     * 获取里程碑签到奖励
     */
    public function getCheckinReward(): Collection
    {
        return $this->checkinRewardService->getAllCheckInReward();
    }

    /**
     * 签到任务
     * @param int $member_id
     * @param string $ip_address
     * @return ResultService
     */
    public function check_task(int $member_id, string $ip_address): ResultService
    {
        // 获取签到任务奖励
        $check_reward_amount = $this->systemSettingService->getSettingByKey("check_reward_amount");
        // 获取签到成功率
        $check_success_rate = $this->systemSettingService->getSettingByKey("check_success_rate");
        // 获取签到图文任务数量
        $check_image_text_count = $this->systemSettingService->getSettingByKey("check_image_text_count");
        // 获取签到图像数学任务数量
        $check_image_math_count = $this->systemSettingService->getSettingByKey("check_image_math_count");
        // 获取签到图片点击任务数量
        $check_image_click_count = $this->systemSettingService->getSettingByKey("check_image_click_count");

        // 获取里程碑签到奖励
        $checkInReward = $this->checkinRewardService->getAllCheckInReward();

        // 定义当前时间
        $current_date = Carbon::now();
        // 获取今日的任务统计信息
        $statsInfo = $this->taskWorkerStatsService->getTaskStatsInfo($member_id, $current_date->copy()->toDateString());
        if ($statsInfo->isEmpty()) {
            return ResultService::failure("You have not yet met all the task standards for today.");
        }
        // 查询今日图文任务数量
        $image_text_count = $statsInfo->where('task_type','image_text')->value('completed');
        if ($image_text_count < (int)$check_image_text_count) {
            return ResultService::failure("You have not yet met all the task standards for today.");
        }
        // 查询今日图像数学任务数量
        $image_math_count = $statsInfo->where('task_type','image_math')->value('completed');
        if ($image_math_count < (int)$check_image_math_count) {
            return ResultService::failure("You have not yet met all the task standards for today.");
        }
        // 查询今日图片点击任务数量
        $image_click_count = $statsInfo->where('task_type','image_click')->value('completed');
        if ($image_click_count < (int)$check_image_click_count) {
            return ResultService::failure("You have not yet met all the task standards for today.");
        }
        // 获取今日成功率
        $success_rate = $this->getTodayTaskWorkerSuccessRate($member_id);
        if ($success_rate < (int)$check_success_rate) {
            return ResultService::failure("You have not yet met all the task standards for today.");
        }

        // 查询签到统计表
        $checkin_stats = MemberCheckinStat::where('member_id', $member_id)->first();

        // 检查今日是否已经签到
        if ($checkin_stats->last_checkin_date && $checkin_stats->last_checkin_date == $current_date->copy()->toDateString()) {
            return ResultService::failure("You've already checked in today. Come back tomorrow!");
        }

        // 检查是否昨日签到过
        if ($checkin_stats->last_checkin_date && $checkin_stats->last_checkin_date == $current_date->copy()->subDay()->toDateString()) {
            $is_continuous = true;
        } else {
            $is_continuous = false;
        }

        try {
            // 生成签到订单号
            $order_no = date('YmdHis') . str_pad((string)$member_id, 8, '0', STR_PAD_LEFT) . random_int(1000, 9999);
            return Db::transaction(function () use ($member_id, $ip_address, $current_date, $order_no, $check_reward_amount, $is_continuous, $checkInReward){
                // 更新签到统计
                $checkin_stats = MemberCheckinStat::where('member_id', $member_id)->lockForUpdate()->first();
                $checkin_stats->total_days += 1;
                $checkin_stats->continuous_days = $is_continuous ? $checkin_stats->continuous_days + 1 : 1;
                $checkin_stats->max_continuous_days = $is_continuous ? $checkin_stats->max_continuous_days + 1 : 1;
                $checkin_stats->last_checkin_date = $current_date->copy()->toDateString();
                $checkin_stats->total_reward_amount = bcadd($checkin_stats->total_reward_amount, $check_reward_amount);
                if (!$checkin_stats->save()) {
                    throw new BusinessException("Check-in failed, please try again later.");
                }
                // 写入签到记录
                $memberCheckin = new MemberCheckin();
                $memberCheckin->member_id = $member_id;
                $memberCheckin->checkin_date = $current_date->copy()->toDateString();
                $memberCheckin->reward_amount = $check_reward_amount;
                $memberCheckin->checkin_time = $current_date->copy()->toDateTimeString();
                $memberCheckin->ip_address = $ip_address;
                if (!$memberCheckin->save()) {
                    throw new BusinessException("Check-in failed, please try again later.");
                }

                // 发送签到奖励
                //$this->balanceService->task_inc($member_id, $check_reward_amount, $order_no, 'task');

                // 达到里程碑奖励
                if ($checkInReward->isNotEmpty()) {
                    // 取出最大的奖励周期
                    $cycleDays = (int)$checkInReward->max('checkin_days');

                    if ($cycleDays <= 0) {
                        throw new BusinessException("Check-in reward configuration error.");
                    }

                    // 计算当前处于第几轮的第几天
                    $rewardDay = $checkin_stats->continuous_days % $cycleDays;

                    if ($rewardDay === 0) {
                        $rewardDay = $cycleDays;
                    }

                    // 查有没有这个里程碑奖励
                    $reward = $checkInReward->where('checkin_days', $rewardDay)->first();

                    if ($reward) {
                        // 生成签到订单号
                        $order_no = date('YmdHis') . str_pad((string)$member_id, 8, '0', STR_PAD_LEFT) . random_int(1000, 9999);
                        // 发送里程碑奖励
                        $this->balanceService->task_inc($member_id, $reward->reward_amount, $order_no, 'task');
                    }
                }

                return ResultService::success("You have met all the task requirements; your reward will be issued later.");
            });
        } catch (BusinessException $e) {
            return ResultService::failure($e->getMessage());
        } catch (\Throwable $e) {
            return ResultService::failure('System error, failed to create ticket, please try again later');
        }
    }
}