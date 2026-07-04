<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    #[Inject]
    protected SessionInterface $session;

    #[Inject]
    protected \Hyperf\HttpServer\Contract\ResponseInterface $response;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 共享认证管理信息
        $member_id = $this->session->get('member_id');
        // 判断认证管理信息
        if (!$member_id) {
            return $this->response->redirect('/auth/signin');
        }
        // 将会员ID添加到请求属性中，方便后续处理
        $request = $request->withAttribute('member_id', $member_id);

        return $handler->handle($request);
    }
}
