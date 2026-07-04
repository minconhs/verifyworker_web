<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class MemberController extends AbstractController
{
    /**
     * 登出
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/member/signout')]
    public function signout(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $this->session->clear();
        return $this->redirect_success('/auth/signin');
    }

    /**
     * 切换工作类型
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/member/switch_platform')]
    public function switch_platform(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $work_type = $request->query('platform', 'client');
        if (!in_array($work_type, ['client', 'worker'])) {
            $work_type = 'client';
        }
        // 更新工作类型
        $this->session->set('work_type', $work_type);
        return $this->redirect_success('/console');
    }
}