<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\WalletWithdrawRequest;
use App\Service\WalletTaskService;
use App\Service\WithdrawalAmountService;
use App\Service\WithdrawalService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class WithdrawController extends AbstractController
{
    #[Inject]
    protected WithdrawalService $withdrawalService;

    #[Inject]
    protected WalletTaskService $walletTaskService;

    #[Inject]
    protected WithdrawalAmountService $withdrawalAmountService;


    /**
     * 提现页面
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/wallet/withdraw')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 查询钱包信息
        $wallet_task = $this->walletTaskService->getWalletInfo($request->getAttribute('member_id'));
        // 查询提现成功的次数
        $successful_withdrawals_count = $this->withdrawalService->getSuccessfulWithdrawalsCount($request->getAttribute('member_id'));
        // 查询审核中的提现记录数量
        $pending_withdrawals_count = $this->withdrawalService->getPendingWithdrawalsCount($request->getAttribute('member_id'));
        // 查询提现成功的总金额
        $successful_withdrawals_total_amount = $this->withdrawalService->getSuccessfulWithdrawalsTotalAmount($request->getAttribute('member_id'));
        // 查询提现记录
        $pagination = $this->withdrawalService->paginate($request->getAttribute('member_id'));
        // 获取提现面额列表
        $amount_list = $this->withdrawalAmountService->getAllWithdrawalAmount();
        // 渲染视图
        return $this->render('withdraw/index', [
            'wallet_task' => $wallet_task,
            'successful_withdrawals_count' => $successful_withdrawals_count,
            'pending_withdrawals_count' => $pending_withdrawals_count,
            'successful_withdrawals_total_amount' => $successful_withdrawals_total_amount,
            'amount_list' => $amount_list,
            'pagination' => $pagination,
        ]);
    }

    /**
     * 提现提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/wallet/withdraw/submit')]
    public function submit(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, WalletWithdrawRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/wallet/withdraw', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 提现
        $result = $this->withdrawalService->submit_withdraw($request->getAttribute('member_id'), $validate['amount'], $validate['method'], $validate['account'], $validate['password']);
        if(!$result->status) {
            return $this->redirect_error('/wallet/withdraw', $result->message, $validate);
        }
        return $this->redirect_success('/wallet/withdraw', $result->message);
    }

    /**
     * 历史记录
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/wallet/withdraw/records')]
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
        $pagination = $this->withdrawalService->paginate($request->getAttribute('member_id'),(int)$page, (int)$per_page, $filters, ['member']);
        return $this->render('withdraw/records', [
            'pagination' => $pagination
        ]);
    }
}