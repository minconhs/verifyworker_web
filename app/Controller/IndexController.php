<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
class IndexController extends AbstractController
{
    #[GetMapping('/')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('index/index');
    }

    #[GetMapping('/pricing')]
    public function pricing(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('index/pricing');
    }

    #[GetMapping('/docs')]
    public function docs(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('index/docs');
    }

    #[GetMapping('/help')]
    public function help(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('index/help');
    }

    #[GetMapping('/about')]
    public function about(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('index/about');
    }

    #[GetMapping('/privacy')]
    public function privacy(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('index/privacy');
    }

    #[GetMapping('/terms')]
    public function terms(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('index/terms');
    }
}
