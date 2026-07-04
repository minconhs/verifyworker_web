<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\WalletTransferRequest;
use App\Service\TransferService;
use App\Service\WalletTaskService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class TransferController extends AbstractController
{
    #[Inject]
    protected WalletTaskService $walletTaskService;

    #[Inject]
    protected TransferService $transferService;
    
    #[GetMapping('/wallet/transfer')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 查询任务余额
        $wallet_task = $this->walletTaskService->getWalletInfo($request->getAttribute('member_id'));
        // 获取总转账金额
        $total_transfer_amount = $this->transferService->getTotalTransferAmount($request->getAttribute('member_id'));
        // 获取转账次数
        $total_transfer_count = $this->transferService->getTotalTransferCount($request->getAttribute('member_id'));
        // 获取转账记录列表
        $pagination = $this->transferService->paginate($request->getAttribute('member_id'));
        return $this->render('transfer/index', [
            'wallet_task' => $wallet_task,
            'total_transfer_amount' => $total_transfer_amount,
            'total_transfer_count' => $total_transfer_count,
            'pagination' => $pagination,
        ]);
    }

    /**
     * 转账提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/wallet/transfer/submit')]
    public function submit(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, WalletTransferRequest::class);
        if ($validator->fails()) {
            // 验证失败，重定向回登录页面并带上错误信息和旧输入数据
            return $this->redirect_error('/wallet/transfer', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 转账
        $result = $this->transferService->submit_transfer($request->getAttribute('member_id'), $validate['email'],$validate['password'], $validate['amount']);
        if(!$result->status) {
            return $this->redirect_error('/wallet/transfer', $result->message, $validate);
        }
        return $this->redirect_success('/wallet/transfer', $result->message);
    }

    /**
     * 历史记录
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/wallet/transfer/records')]
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
        $pagination = $this->transferService->paginate($request->getAttribute('member_id'),(int)$page, (int)$per_page, $filters, ['member']);
        return $this->render('transfer/records', [
            'pagination' => $pagination
        ]);
    }
}