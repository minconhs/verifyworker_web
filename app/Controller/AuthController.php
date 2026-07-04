<?php

namespace App\Controller;

use App\Request\SigninRequest;
use App\Request\SignupRequest;
use App\Service\AuthService;
use App\Service\MemberOauthService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
class AuthController extends AbstractController
{
    #[Inject]
    protected AuthService $authService;

    #[Inject]
    protected MemberOauthService $memberOauthService;

    /**
     * 登录页面
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/auth/signin')]
    public function signin_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('auth/signin');
    }

    /**
     * 登录提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/auth/signin')]
    public function signin_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SigninRequest::class);
        if ($validator->fails()) {
            // 验证失败，重定向回登录页面并带上错误信息和旧输入数据
            return $this->redirect_error('/auth/signin', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 获取IP地址
        $ip_address = $this->get_client_ip($request);
        // 获取请求代理
        $user_agent = $this->get_user_agent($request);
        // 登录
        $result = $this->authService->login($validate['username'], $validate['password'], $ip_address, $user_agent);
        if (!$result->status) {
            return $this->redirect_error('/auth/signin', $result->message, $validate);
        }
        return $response->redirect('/console');
    }

    /**
     * 注册页面
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/auth/signup')]
    public function signup_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $referral = $request->query('referral');
        return $this->render('auth/signup', ['referral' => $referral]);
    }

    /**
     * 注册提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/auth/signup')]
    public function signup_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SignupRequest::class);
        if ($validator->fails()) {
            // 验证失败，重定向回登录页面并带上错误信息和旧输入数据
            return $this->redirect_error('/auth/signin', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 获取IP地址
        $ip_address = $this->get_client_ip($request);
        // 获取推荐码
        $referral = $request->post('referral');
        // 注册
        $result = $this->authService->signup($validate['username'], $validate['email'], $validate['password'], $ip_address, $referral);
        if (!$result->status) {
            return $this->redirect_error($request->header('referer', '/'), $result->message, $validate);
        }
        // 注册成功，重定向到登录页面
        return $this->redirect_success('/auth/signin', $result->message);
    }

    /**
     * 谷歌登录
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/auth/google')]
    public function google_signin(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取谷歌登录url
        $auth_url = $this->authService->google_login();
        return $response->redirect($auth_url);
    }
}