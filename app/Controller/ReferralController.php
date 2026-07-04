<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Service\ReferralService;
use App\Service\TaskCommissionService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class ReferralController extends AbstractController
{
    #[Inject]
    protected ReferralService $referralService;

    #[Inject]
    protected TaskCommissionService $taskCommissionService;

    /**
     * 推荐计划
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/referral')]
    public function update(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取推荐人数
        $referral_count = $this->referralService->getReferralCount($request->getAttribute('member_id'));
        // 获取推荐奖励金额
        $referral_earnings = $this->referralService->getReferralEarnings($request->getAttribute('member_id'));
        // 获取推荐码
        $referral_code = $this->referralService->getReferralCode($request->getAttribute('member_id'));
        // 获取推荐链接
        $referral_link = $this->referralService->getReferralLink($request->getAttribute('member_id'));
        // 获取佣金记录
        $pagination = $this->taskCommissionService->paginate($request->getAttribute('member_id'),1,10, [], ['member']);
        // 渲染视图
        return $this->render('referral/index', [
            'referral_count' => $referral_count,
            'referral_earnings' => $referral_earnings,
            'referral_code' => $referral_code,
            'referral_link' => $referral_link,
            'pagination' => $pagination
        ]);
    }

    /**
     * 历史记录
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/referral/records')]
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
        $pagination = $this->taskCommissionService->paginate($request->getAttribute('member_id'),(int)$page, (int)$per_page, $filters, ['member']);
        return $this->render('referral/records', [
            'pagination' => $pagination
        ]);
    }
}