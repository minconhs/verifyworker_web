<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Service\MemberOauthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class MemberOauthController extends AbstractController
{
    #[Inject]
    protected MemberOauthService $memberOauthService;

    /**
     * 谷歌绑定
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/oauth/google/bind')]
    public function google_bind(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取谷歌绑定url
        return $response->redirect($this->memberOauthService->google_bind($request->getAttribute('member_id')));
    }

    /**
     * 谷歌解绑
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/oauth/google/unbind')]
    public function google_unbind(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取谷歌绑定url
        $result = $this->memberOauthService->google_unbind($request->getAttribute('member_id'));
        if (!$result->status) {
            return $this->redirect_error('/profile', $result->message);
        }
        return $this->redirect_success('/profile', $result->message);
    }
}