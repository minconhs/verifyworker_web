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

use App\Service\FlashService;
use App\Service\MemberService;
use App\Service\ValidationService;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    #[Inject]
    protected RenderInterface $view;

    #[Inject]
    protected SessionInterface $session;

    #[Inject]
    protected FlashService $flashService;

    #[Inject]
    protected ValidationService $validationService;

    #[Inject]
    protected MemberService $memberService;

    /**
     * 渲染视图
     * @param string $template 模板路径，例如 'web/index'
     * @param array $data 传递给视图的数据
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function render(string $template, array $data = []): \Psr\Http\Message\ResponseInterface
    {
        // 共享路由路径
        $share_data['current_route'] = $this->request->getUri()->getPath();
        // 共享闪存错误信息
        $share_data['error'] = $this->flashService->get('error');
        // 共享闪存成功信息
        $share_data['success'] = $this->flashService->get('success');
        // 共享旧输入数据
        $share_data['old'] = $this->flashService->get('old') ?? [];
        // 共享认证用户信息
        $member_id = $this->session->get('member_id');
        // 判断认证用户信息
        if ($member_id) {
            $share_data['member'] = $this->memberService->getMemberInfoById($member_id);
            $share_data['platform'] = $this->session->get('work_type', 'client');
        }

        // 共享csrf_token
        $csrf_token = $this->session->get('csrf_token');
        if ($csrf_token) {
            $share_data['csrf_token'] = $csrf_token;
        }
        return $this->view->render($template, array_merge($share_data, $data));
    }

    /**
     * 重定向到指定 URL，并设置闪存提示信息和旧输入数据
     * @param string $url
     * @param string|null $message
     * @param array $old
     * @param int $status
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function redirect_success(string $url, string $message = null, array $old = [], int $status = 302): \Psr\Http\Message\ResponseInterface
    {
        // 设置闪存提示登录成功
        if (!is_null($message)) {
            $this->flashService->set('success', $message);
        }
        // 设置闪存输入数据
        if (!empty($old)) {
            $this->flashService->old($old);
        }
        return $this->response->redirect($url, $status);
    }

    /**
     * 重定向到指定 URL，并设置闪存提示信息和旧输入数据
     * @param string $url
     * @param string|null $message
     * @param array $old
     * @param int $status
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function redirect_error(string $url, string $message = null, array $old = [], int $status = 302): \Psr\Http\Message\ResponseInterface
    {
        // 设置闪存提示登录成功
        if (!is_null($message)) {
            $this->flashService->set('error', $message);
        }
        // 设置闪存输入数据
        if (!empty($old)) {
            $this->flashService->old($old);
        }
        return $this->response->redirect($url, $status);
    }

    /**
     * 成功响应
     * @param string $message
     * @param array|null $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function success(string $message, array|null $data = null): \Psr\Http\Message\ResponseInterface
    {
        $response_data = [
            'success' => true,
            'code' => 0,
            'message' => $message,
        ];
        if (!is_null($data)) {
            $response_data['data'] = $data;
        }
        return $this->response->json($response_data);
    }

    /**
     * 失败响应
     * @param string $message
     * @param int $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function fail(string $message, int $code = 10000): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json([
            'success' => false,
            'code' => $code,
            'message' => $message,
        ]);
    }

    /**
     * 获取客户端 IP 地址
     * @param RequestInterface $request
     * @return string
     */
    public function get_client_ip(RequestInterface $request): string
    {
        // 优先获取 x-forwarded-for (适合多级代理)
        $ip_address = $request->getHeaderLine('x-forwarded-for');

        // 如果X-Forwarded-For未获取尝试使用x-real-ip
        if (empty($ip_address)) {
            $ip_address = $request->getHeaderLine('x-real-ip');
        }

        // 如果仍未获取尝试使用 remote_addr
        if (empty($ip_address)) {
            $serverParams = $request->getServerParams();
            $ip_address = $serverParams['remote_addr'] ?? '0.0.0.0';
        }

        // 检查是否包含逗号（可能存在多个IP地址），取第一个非空的IP地址
        if (str_contains($ip_address, ',')) {
            $ip_list = explode(',', $ip_address);
            foreach ($ip_list as $ip) {
                $address = trim($ip);
                // 检查非空与IP地址格式
                if (!empty($address) && filter_var($address, FILTER_VALIDATE_IP)) {
                    $ip_address = $address;
                    break;
                }
            }
        }
        return $ip_address;
    }

    /**
     * 获取客户端代理
     * @param RequestInterface $request
     * @return string
     */
    public function get_user_agent(RequestInterface $request): string
    {
        return $request->header('User-Agent', 'unknown');
    }
}
