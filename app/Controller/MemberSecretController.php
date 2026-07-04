<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\SecretCreateRequest;
use App\Service\MemberSecretService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class MemberSecretController extends AbstractController
{
    #[Inject]
    protected MemberSecretService $secretService;

    /**
     * 密钥页面
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/secret')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取分页参数
        $page = $request->query('page', 1);
        // 获取每页记录数
        $per_page = $request->query('per_page', 10);
        // 获取过滤条件，排除分页参数
        $filters = $request->query();
        // 设置表单回填数据
        $this->flashService->old($filters);
        // 获取会员密钥分页数据
        $pagination = $this->secretService->paginate($request->getAttribute('member_id'), $page, $per_page, $filters);
        return $this->render('member_secret/index', [
            'pagination' => $pagination
        ]);
    }

    /**
     * 创建密钥
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/secret/create')]
    public function create_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('secret/create');
    }

    /**
     * 创建密钥提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/secret/create')]
    public function create_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, SecretCreateRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/secret/create', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 创建密钥
        $result = $this->secretService->create($request->getAttribute('member_id'), $validate['hook_url'], $validate['white_ip'], $validate['remark']);
        if (!$result->status) {
            return $this->redirect_error('/secret/create', $result->message, $request->post());
        }
        return $this->redirect_success('/secret', $result->message);
    }

    /**
     * 删除密钥
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param int $secret_id
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/secret/delete/{secret_id:\d+}')]
    public function delete(RequestInterface $request, ResponseInterface $response, int $secret_id): \Psr\Http\Message\ResponseInterface
    {
        // 删除密钥
        $result = $this->secretService->delete($request->getAttribute('member_id'), $secret_id);
        if (!$result->status) {
            return $this->redirect_error('/secret', $result->message);
        }
        return $this->redirect_success('/secret', $result->message);
    }
}