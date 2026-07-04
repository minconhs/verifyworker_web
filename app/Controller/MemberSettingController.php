<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\SettingsEmailChangeRequest;
use App\Request\SettingsNoticeRequest;
use App\Request\SettingsPaymentPasswordChangeRequest;
use App\Request\SettingsPaymentPasswordResetRequest;
use App\Service\MemberSettingService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;


#[Controller]
#[Middleware(AuthMiddleware::class)]
class MemberSettingController extends AbstractController
{
    #[Inject]
    protected MemberSettingService $memberSettingService;

    /**
     * 设置首页
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/settings')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $response->redirect('/settings/email');
    }

    /**
     * 邮箱设置
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/settings/email')]
    public function email_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取安全分
        $securityScore = $this->memberService->getSecurityScore($request->getAttribute('member_id'));
        return $this->render('member_setting/email',[
            'tab' => 'email',
            'security_score' => $securityScore,
        ]);
    }

    /**
     * 邮箱设置提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/settings/email')]
    public function email_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SettingsEmailChangeRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/settings/email', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 修改邮箱
        $result = $this->memberService->changeEmail($request->getAttribute('member_id'), $request->post('email'), $request->post('password'));
        if (!$result->status) {
            return $this->redirect_error('/settings/email', $result->message, $request->post());
        }
        return $this->redirect_success('/settings/email', $result->message);
    }

    /**
     * 修改密码
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/settings/password')]
    public function password_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取安全分
        $securityScore = $this->memberService->getSecurityScore($request->getAttribute('member_id'));
        return $this->render('member_setting/password',[
            'tab' => 'password',
            'security_score' => $securityScore,
        ]);
    }

    /**
     * 修改密码提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/settings/password')]
    public function password_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SettingsEmailChangeRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/settings/password', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 修改密码
        $result = $this->memberService->changePassword($request->getAttribute('member_id'), $validate['old_password'], $validate['password']);
        if (!$result->status) {
            return $this->redirect_error('/settings/password', $result->message, $request->post());
        }
        return $this->redirect_success('/settings/password', $result->message);
    }

    /**
     * 修改支付密码
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/settings/payment-password')]
    public function payment_password_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取安全分
        $securityScore = $this->memberService->getSecurityScore($request->getAttribute('member_id'));
        return $this->render('member_setting/payment-password',[
            'tab' => 'payment-password',
            'security_score' => $securityScore,
        ]);
    }

    /**
     * 修改支付密码
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/settings/payment-password')]
    public function payment_password_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SettingsPaymentPasswordChangeRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/settings/payment-password', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 修改支付密码
        $result = $this->memberService->changePaymentPassword($request->getAttribute('member_id'), $validate['old_password'], $validate['password']);
        if (!$result->status) {
            return $this->redirect_error('/settings/payment-password', $result->message, $request->post());
        }
        return $this->redirect_success('/settings/payment-password', $result->message);
    }

    /**
     * 忘记支付密码
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/settings/forgot-payment-password')]
    public function forgot_payment_password_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取安全分
        $securityScore = $this->memberService->getSecurityScore($request->getAttribute('member_id'));
        return $this->render('member_setting/forgot-payment-password',[
            'tab' => 'forgot-payment-password',
            'security_score' => $securityScore,
        ]);
    }

    /**
     * 忘记支付密码提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/settings/forgot-payment-password')]
    public function forgot_payment_password_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SettingsPaymentPasswordResetRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/settings/payment-password', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 重置支付密码
        $result = $this->memberService->resetPaymentPassword($request->getAttribute('member_id'), $validate['verification_code'], $validate['password']);
        if (!$result->status) {
            return $this->redirect_error('/settings/forgot-payment-password', $result->message, $validate);
        }
        return $this->redirect_success('/settings/forgot-payment-password', $result->message);
    }

    /**
     * 忘记支付发送代码
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/settings/forgot-payment-password/send-code')]
    public function forgot_payment_password_send_code(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        $result = $this->memberService->sendResetPaymentPasswordEmail($request->getAttribute('member_id'));
        if (!$result->status) {
            return $this->redirect_error('/settings/forgot-payment-password', $result->message);
        }
        return $this->redirect_success('/settings/forgot-payment-password', $result->message);
    }

    /**
     * 通知设置
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/settings/notice')]
    public function notice_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取安全分
        $securityScore = $this->memberService->getSecurityScore($request->getAttribute('member_id'));
        // 获取会员通知设置
        $setting = $this->memberSettingService->getMemberSettingInfo($request->getAttribute('member_id'));
        return $this->render('member_setting/notice', [
            'tab' => 'notice',
            'security_score' => $securityScore,
            'setting' => $setting,
        ]);
    }

    /**
     * 通知设置提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/settings/notice')]
    public function update(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SettingsNoticeRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/settings/notice', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 更新会员通知设置
        $result = $this->memberSettingService->updateMemberSettingInfo($request->getAttribute('member_id'), $validate);
        if (!$result->status) {
            return $this->redirect_error('/settings/notice', $result->message, $validate);
        }
        return $this->redirect_success('/settings/notice', $result->message);
    }
}