<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Service\CheckInService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class CheckInController extends AbstractController
{
    #[Inject]
    protected CheckInService $checkInService;

    #[GetMapping('/checkin')]
    public function solve(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取今日签到奖励
        $todayCheckinRewardAmount = $this->checkInService->getTodayCheckinRewardAmount($request->getAttribute('member_id'));
        // 获取今日任务完成进度
        $taskCompleted = $this->checkInService->getTodayTaskCompleted($request->getAttribute('member_id'));
        // 获取成功率
        $taskSuccessRate = $this->checkInService->getTodayTaskWorkerSuccessRate($request->getAttribute('member_id'));
        // 获取签到日历
        $checkInCalendar = $this->checkInService->getCheckInCalendar($request->getAttribute('member_id'));
        // 获取任务进度统计
        $todayTaskStats = $this->checkInService->getTodayTaskStats($request->getAttribute('member_id'));
        // 获取里程碑签到奖励
        $checkinReward = $this->checkInService->getCheckinReward();

        return $this->render('member_checkin/index', [
            'today_checkin_reward_amount' => $todayCheckinRewardAmount,
            'today_task_completed' => $taskCompleted,
            'today_task_success_rate' => $taskSuccessRate,
            'checkin_calendar' => $checkInCalendar,
            'today_task_stats' => $todayTaskStats,
            'checkin_reward' => $checkinReward
        ]);
    }

    /**
     * 签到
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/check_task')]
    public function check_task(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $result = $this->checkInService->check_task($request->getAttribute('member_id'), $this->get_client_ip($request));
        if (!$result->status) {
            return $this->redirect_error("/checkin", $result->message);
        }
        return $this->redirect_success('/checkin', $result->message);
    }
}