<?php

namespace App\Controller;

use App\Middleware\ApiMiddleware;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller('/api')]
#[Middleware(ApiMiddleware::class)]
class ApiController extends AbstractController
{
    /**
     * 解决提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('solve/submit')]
    public function solve(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->fail('The process failed. Please try again later.');
    }

    /**
     * 查询结果
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('solve/result')]
    public function result(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->fail('The process failed. Please try again later.');
    }

    /**
     * 查询余额
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('solve/balance')]
    public function balance(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->fail('The process failed. Please try again later.');
    }
}