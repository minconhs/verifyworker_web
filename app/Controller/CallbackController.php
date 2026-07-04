<?php

namespace App\Controller;

use App\Request\GoogleCallbackRequest;
use App\Service\CallbackService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
class CallbackController extends AbstractController
{
    #[Inject]
    protected CallbackService $callbackService;

    /**
     * 谷歌绑定
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/callback/oauth/google/bind')]
    public function google_bind(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->query();
        // 验证数据
        $validator = $this->validationService->validate($data, GoogleCallbackRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/profile', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 调用服务
        $result = $this->callbackService->google_bind($validate['code'], $validate['state']);
        if (!$result->status) {
            return $this->redirect_error('/profile', $result->message);
        }
        // 绑定成功
        return $this->redirect_success('/profile',$result->message);
    }

    /**
     * 谷歌登录
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/callback/oauth/google/login')]
    public function google_login(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->query();
        // 验证数据
        $validator = $this->validationService->validate($data, GoogleCallbackRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/auth/signin', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 调用服务
        $result = $this->callbackService->google_login($validate['code'], $validate['state'], $this->get_client_ip($request), $this->get_user_agent($request));
        if (!$result->status) {
            return $this->redirect_error('/auth/signin', $result->message);
        }
        // 登录成功，重定向到控制台
        return $this->redirect_success('/console');
    }
}