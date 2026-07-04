<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Service\CheckinRewardService;
use App\Service\MemberLogService;
use App\Service\TaskClientStatsService;
use App\Service\TaskWorkerStatsService;
use App\Service\WalletRechargeService;
use App\Service\WalletTaskService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class ConsoleController extends AbstractController
{
    #[Inject]
    protected MemberLogService $memberLogService;

    #[Inject]
    protected CheckinRewardService $checkinRewardService;

    #[Inject]
    protected TaskWorkerStatsService $taskWorkerStatsService;

    #[Inject]
    protected TaskClientStatsService $taskClientStatsService;

    #[Inject]
    protected WalletTaskService $walletTaskService;

    #[Inject]
    protected WalletRechargeService $walletRechargeService;

    /**
     * 控制台首页
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/console')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取登录日志
        $pagination = $this->memberLogService->paginate($request->getAttribute('member_id'));
        // 获取当前平台
        $currentWorkType = $this->session->get('work_type', 'worker');
        // 判断当前的工作类型
        if ($currentWorkType === 'worker') {
            // 获取签到里程碑奖励
            $check_in_reward = $this->checkinRewardService->getAllCheckInReward();
            // 获取今日完成的任务
            $today_completed_count = $this->taskWorkerStatsService->getTaskStatusCount($request->getAttribute('member_id'), 'completed');
            // 获取今日任务收入
            $today_total_amount = $this->taskWorkerStatsService->getTaskStatusCount($request->getAttribute('member_id'), 'total_amount');
            // 获取成功率
            $success_rate = $this->taskWorkerStatsService->getAllTaskSuccessRate($request->getAttribute('member_id'));
            // 获取任务余额
            $wallet_task = $this->walletTaskService->getWalletInfo($request->getAttribute('member_id'));
            // 获取一周统计信息
            $week_stats = $this->taskWorkerStatsService->getTaskWeekStats($request->getAttribute('member_id'));
            // 获取折线图信息
            $chart = $this->taskWorkerStatsService->chart($request->getAttribute('member_id'));
            return $this->render('console/worker', [
                'check_in_reward' => $check_in_reward,
                'today_completed_count' => $today_completed_count,
                'today_total_amount' => $today_total_amount,
                'success_rate' => $success_rate,
                'wallet_task' => $wallet_task,
                'week_stats' => $week_stats,
                'pagination' => $pagination,
                'chart' => $chart
            ]);
        } else {
            // 获取充值余额
            $wallet_recharge = $this->walletRechargeService->getWalletInfo($request->getAttribute('member_id'));
            // 获取本月支出金额
            $monet_expend = $this->taskClientStatsService->getMonthTaskExpend($request->getAttribute('member_id'));
            // 获取完成的任务
            $completed_count = $this->taskClientStatsService->getTaskStatusCount($request->getAttribute('member_id'), 'completed');
            // 获取成功率
            $success_rate = $this->taskClientStatsService->getTaskSuccessRate($request->getAttribute('member_id'));
            // 获取折线图信息
            $chart = $this->taskClientStatsService->chart($request->getAttribute('member_id'));
            return $this->render('console/client', [
                'wallet_recharge' => $wallet_recharge,
                'monet_expend' => $monet_expend,
                'completed_count' => $completed_count,
                'success_rate' => $success_rate,
                'pagination' => $pagination,
                'chart' => $chart
            ]);
        }
    }
}