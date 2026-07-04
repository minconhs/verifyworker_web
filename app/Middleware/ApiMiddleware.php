<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiMiddleware implements MiddlewareInterface
{
    #[Inject]
    protected SessionInterface $session;

    #[Inject]
    protected \Hyperf\HttpServer\Contract\ResponseInterface $response;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 获取授权请求头
        $authorization = $request->getHeaderLine('Authorization');
        // 获取授权密钥
        $token = preg_replace('/^Bearer\s+/i', '', $authorization);
        if (empty($token)) {
            return $this->fail("Unauthorized, invalid API key", 401);
        }

        return $handler->handle($request);
    }

    /**
     * 失败响应
     * @param string $message
     * @param int $code
     * @return ResponseInterface
     */
    protected function fail(string $message, int $code = 10000): ResponseInterface
    {
        return $this->response->json([
            'success' => false,
            'code' => $code,
            'message' => $message,
        ]);
    }
}
