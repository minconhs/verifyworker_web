<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Service\WalletCommissionService;
use App\Service\WalletFlowService;
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
class WalletController extends AbstractController
{
    #[Inject]
    protected WalletRechargeService $walletRechargeService;

    #[Inject]
    protected WalletTaskService $walletTaskService;

    #[Inject]
    protected WalletCommissionService $walletCommissionService;

    #[Inject]
    protected WalletFlowService $walletFlowService;

    #[GetMapping('/wallet')]
    public function update(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $wallet_type = $request->query('wallet_type', '');
        if (!in_array($wallet_type, ['recharge', 'task', 'commission'])) {
            $wallet_type = '';
        }
        // 获取充值钱包
        $wallet_recharge = $this->walletRechargeService->getWalletInfo($request->getAttribute('member_id'));
        // 获取任务钱包
        $wallet_task = $this->walletTaskService->getWalletInfo($request->getAttribute('member_id'));
        // 获取佣金钱包
        $wallet_commission = $this->walletCommissionService->getWalletInfo($request->getAttribute('member_id'));

        $recharge_balance = $wallet_recharge->balance ?? '0.00000';
        $recharge_frozen = $wallet_recharge->frozen ?? '0.00000';
        // 充值钱包总余额（可用+冻结）
        $sum_recharge_balance = bcadd($recharge_balance, $recharge_frozen, 5);
        // 冻结的充值余额占总充值余额的百分比（避免除以0）
        $recharge_frozen_percentage = $sum_recharge_balance > 0 ? bcdiv($recharge_frozen, $sum_recharge_balance, 2) * 100 : '0';

        $task_balance = $wallet_task->balance ?? '0.00000';
        $task_frozen = $wallet_task->frozen ?? '0.00000';
        // 任务钱包总余额（可用+冻结）
        $sum_task_balance = bcadd($task_balance, $task_frozen, 5);
        // 冻结的充值余额占总充值余额的百分比（避免除以0）
        $task_frozen_percentage = $sum_task_balance > 0 ? bcdiv($task_frozen, $sum_task_balance, 2) * 100 : '0';

        $commission_balance = $wallet_commission->balance ?? '0.00000';
        $commission_frozen = $wallet_commission->frozen ?? '0.00000';
        // 佣金钱包总余额（可用+冻结）
        $sum_commission_balance = bcadd($commission_balance, $commission_frozen, 5);
        // 冻结的充值余额占总充值余额的百分比（避免除以0）
        $commission_frozen_percentage = $sum_commission_balance > 0 ? bcdiv($commission_frozen, $sum_commission_balance, 2) * 100 : '0';

        // 总余额（充值+任务+佣金的可用余额之和）
        $sum_balance = bcadd(bcadd($recharge_balance, $task_balance, 5), $commission_balance, 5);

        // 总冻结余额（充值+任务+佣金的冻结余额之和）
        $sum_frozen = bcadd(bcadd($recharge_frozen, $task_frozen, 5), $commission_frozen, 5);

        // 流水记录
        $pagination = $this->walletFlowService->paginate($request->getAttribute('member_id'), 1, 10, ['wallet_type' => $wallet_type], ['member'], ['created_at' => 'desc', 'id' =>'desc']);

        return $this->render('wallet/index', [
            'wallet_recharge' => $wallet_recharge,
            'wallet_task' => $wallet_task,
            'wallet_commission' => $wallet_commission,

            'recharge_balance' => $recharge_balance,
            'recharge_frozen' => $recharge_frozen,
            'sum_recharge_balance' => $sum_recharge_balance,
            'recharge_frozen_percentage' => $recharge_frozen_percentage,

            'task_balance' => $task_balance,
            'task_frozen' => $task_frozen,
            'sum_task_balance' => $sum_task_balance,
            'task_frozen_percentage' => $task_frozen_percentage,

            'commission_balance' => $commission_balance,
            'commission_frozen' => $commission_frozen,
            'sum_commission_balance' => $sum_commission_balance,
            'commission_frozen_percentage' => $commission_frozen_percentage,

            'sum_balance' => $sum_balance,
            'sum_frozen' => $sum_frozen,

            'pagination' => $pagination,
            'wallet_type' => $wallet_type,
        ]);
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/wallet/records')]
    public function records(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $page = $request->query('page', 1);
        // 获取每页记录数
        $per_page = $request->query('per_page', 10);
        // 获取过滤条件，排除分页参数
        $filters = $request->query();
        // 设置表单回填数据
        $this->flashService->old($filters);
        // 获取分页结果
        $pagination = $this->walletFlowService->paginate($request->getAttribute('member_id'),(int)$page, (int)$per_page, $filters, ['member'], ['created_at' => 'desc', 'id' =>'desc']);
        return $this->render('wallet/records', [
            'pagination' => $pagination
        ]);
    }
}