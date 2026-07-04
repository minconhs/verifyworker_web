<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\ProfileChangeRequest;
use App\Service\MemberLogService;
use App\Service\MemberOauthService;
use App\Service\MemberProfileService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use League\ISO3166\ISO3166;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class MemberProfileController extends AbstractController
{
    #[Inject]
    protected MemberProfileService $memberProfileService;

    #[Inject]
    protected MemberOauthService $memberOauthService;

    #[Inject]
    protected MemberLogService $memberLogService;

    /**
     * 个人资料页面
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/profile')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取分页参数
        $page = $request->query('page', 1);
        // 获取注册地点
        $location = $this->memberService->getRegisterLocation($request->getAttribute('member_id'));
        // 获取国家列表
        $countries = (new ISO3166)->all();
        // 调用服务层获取个人资料
        $profile_detail = $this->memberProfileService->getProfileInfo($request->getAttribute('member_id'));
        // 获取第三方授权信息
        $oauth = $this->memberOauthService->getMemberOauthInfo($request->getAttribute('member_id'));
        // 获取登录日志
        $pagination = $this->memberLogService->paginate($request->getAttribute('member_id'), $page);
        return $this->render('member_profile/index',[
            'location'  => $location,
            'countries' => $countries,
            'profile' => $profile_detail,
            'oauth' => $oauth,
            'pagination' => $pagination,
        ]);
    }

    /**
     * 更新个人信息
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/profile/update')]
    public function update(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, ProfileChangeRequest::class);
        if ($validator->fails()) {
            // 验证失败，重定向回登录页面并带上错误信息和旧输入数据
            return $this->redirect_error('/profile', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        $result = $this->memberProfileService->updateProfileInfo($request->getAttribute('member_id'), $validate);
        if (!$result->status) {
            return $this->redirect_error('/profile', $result->message);
        }
        return $this->redirect_success('/profile', $result->message);
    }
}