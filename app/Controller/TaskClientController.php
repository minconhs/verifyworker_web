<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Service\TaskClientService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class TaskClientController extends AbstractController
{
    #[Inject]
    protected TaskClientService $taskClientService;

    /**
     * Task Client
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/task/client')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取分页参数
        $page = $request->query('page', 1);
        // 获取每页记录数
        $per_page = $request->query('per_page', 10);
        // 获取分页结果
        $pagination = $this->taskClientService->paginate($request->getAttribute('member_id'), (int)$page, (int)$per_page, [], ['taskType']);
        // 渲染视图
        return $this->render('task_client/index', [
            'pagination' => $pagination,
        ]);
    }
}