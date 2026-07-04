<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\RechargeSubmitRequest;
use App\Service\RechargeService;
use App\Service\WalletRechargeService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class RechargeController extends AbstractController
{
    #[Inject]
    protected RechargeService $rechargeService;

    #[Inject]
    protected WalletRechargeService $walletRechargeService;

    /**
     * 充值页面
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/wallet/deposits')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取充值钱包
        $wallet_recharge = $this->walletRechargeService->getWalletInfo($request->getAttribute('member_id'));
        // 获取成功充值金额
        $successful_recharge_amount = $this->rechargeService->getSuccessfulRechargeAmount($request->getAttribute('member_id'));
        // 获取分页数据
        $pagination = $this->rechargeService->paginate($request->getAttribute('member_id'));
        return $this->render('recharge/index', [
            'wallet_recharge' => $wallet_recharge,
            'successful_recharge_amount' => $successful_recharge_amount,
            'pagination' => $pagination,
        ]);
    }

    /**
     * 充值提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/wallet/deposits/submit')]
    public function submit(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, RechargeSubmitRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/profile', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        $result = $this->rechargeService->submit($request->getAttribute('member_id'), $validate['amount'], $validate['method']);
        if(!$result->status) {
            return $this->redirect_error('/wallet/deposits', $result->message, $validate);
        }
        return $this->redirect_success('/wallet/deposits', $result->data['link']);
    }
}