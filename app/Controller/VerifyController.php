<?php

namespace App\Controller;

use App\Request\TicketCreateRequest;
use App\Request\VerifyTokenRequest;
use App\Service\VerifyService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
class VerifyController extends AbstractController
{
    #[Inject]
    protected VerifyService $verifyService;

    /**
     * 注册验证
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/verify/signup')]
    public function signup_verify(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->query();
        // 验证数据
        $validator = $this->validationService->validate($data, VerifyTokenRequest::class);
        if ($validator->fails()) {
            return $this->render('verify/error', ['message' => $validator->errors()->first()]);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 注册验证
        $result = $this->verifyService->signup_verify($validate['token']);
        if (!$result->status) {
            return $this->render('verify/error', ['message' => $result->message]);
        }
        return $this->render('verify/success', ['message' => $result->message]);
    }

    /**
     * 注册验证
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/verify/email/change')]
    public function email_change_verify(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->query();
        // 验证数据
        $validator = $this->validationService->validate($data, VerifyTokenRequest::class);
        if ($validator->fails()) {
            return $this->render('verify/error', ['message' => $validator->errors()->first()]);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 邮件变更验证
        $result = $this->verifyService->email_change_verify($validate['token']);
        if (!$result->status) {
            return $this->render('verify/error', ['message' => $result->message]);
        }
        return $this->render('verify/success', ['message' => $result->message]);
    }
}