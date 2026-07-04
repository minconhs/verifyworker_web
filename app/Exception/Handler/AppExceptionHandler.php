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

namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Database\Exception\QueryException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\View\RenderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    #[Inject]
    protected RenderInterface $render;

    #[Inject]
    protected StdoutLoggerInterface $logger;

    #[Inject]
    protected ServerRequestInterface $request;

    #[Inject]
    protected \Hyperf\HttpServer\Contract\ResponseInterface $response;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 如果是路由未找到异常，返回 404 页面
        if ($throwable instanceof NotFoundHttpException) {
            return $this->exception_month(404, $throwable->getMessage());
        }

        // 如果是数据库异常
        if ($throwable instanceof QueryException) {
            $this->logger->error("SQL 错误: " . $throwable->getSql());
            $this->logger->error("绑定参数: " . json_encode($throwable->getBindings()));
            $this->logger->error("错误信息: " . $throwable->getMessage());
            return $this->exception_month(500, $throwable->getMessage());
        }

        return $this->exception_month(500, $throwable->getMessage());
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }

    public function exception_month(int $code, string $message): ResponseInterface
    {
        $is_ajax = $this->request->getHeaderLine('x-requested-with') === 'XMLHttpRequest';
        if ($is_ajax) {
            return $this->response->json(['success' => false, 'code' => $code, 'message' => $message]);
        }
        return $this->render->render((string)$code, ['message' => $message]);
    }
}
