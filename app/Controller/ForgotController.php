<?php

namespace App\Controller;

use App\Request\ForgotResetRequest;
use App\Request\ForgotSubmitRequest;
use App\Request\ForgotVerifyRequest;
use App\Service\ForgotService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
class ForgotController extends AbstractController
{
    #[Inject]
    protected ForgotService $forgotService;

    /**
     * 忘记密码
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/forgot')]
    public function forgot_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('forgot/index');
    }

    /**
     * 忘记密码提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/forgot')]
    public function forgot_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, ForgotSubmitRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/forgot', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        $result = $this->forgotService->forgot($validate['email']);
        if (!$result->status) {
            return $this->redirect_error('/forgot', $result->message, $validate);
        }
        // 提交成功，重定向到忘记密码页面，并提示用户检查邮箱
        return $this->redirect_success('/forgot', $result->message);
    }

    /**
     * 重置密码
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/forgot/verify')]
    public function reset(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->query();
        // 验证数据
        $validator = $this->validationService->validate($data, ForgotVerifyRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error($request->header('referer', '/forgot'), $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 验证密钥
        $result = $this->forgotService->verify($validate['token']);
        if (!$result->status) {
            return $this->render('/forgot', ['message' => $result->message]);
        }
        // 验证成功，重定向到重置密码页面，并传递 token 参数
        return $this->render('forgot/reset', [
            'token' => $validate['token']
        ]);
    }

    /**
     * 重置密码提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/forgot/reset')]
    public function reset_password(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, ForgotResetRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error($request->header('referer', '/forgot'), $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        $result = $this->forgotService->reset_password($validate['token'], $validate['password']);
        if (!$result->status) {
            return $this->redirect_error($request->header('referer', '/'), $result->message, $validate);
        }
        // 重置成功，重定向到登录页面
        return $this->redirect_success('/auth/signin', $result->message);
    }
}