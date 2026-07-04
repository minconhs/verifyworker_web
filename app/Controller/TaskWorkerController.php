<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\TaskWorkerCancelRequest;
use App\Request\TaskWorkerCreateRequest;
use App\Request\TaskWorkerFetchRequest;
use App\Request\TaskWorkerQueryRequest;
use App\Request\TaskWorkerSubmitRequest;
use App\Service\TaskOrderService;
use App\Service\TaskWorkerService;
use App\Service\TaskWorkerStatsService;
use App\Service\WalletTaskService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class TaskWorkerController extends AbstractController
{
    #[Inject]
    protected TaskOrderService $taskOrderService;

    #[Inject]
    protected TaskWorkerService $taskWorkerService;

    #[Inject]
    protected TaskWorkerStatsService $taskWorkerStatsService;

    #[Inject]
    protected WalletTaskService $walletTaskService;

    #[GetMapping('/task/worker')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取成功数量
        $completed_count = $this->taskWorkerStatsService->getTaskStatusCount($request->getAttribute('member_id'), 'completed');
        // 获取成功率
        $success_rate = $this->taskWorkerStatsService->getTaskSuccessRate($request->getAttribute('member_id'));
        // 获取任务收入
        $task_income = $this->taskWorkerStatsService->getTaskIncome($request->getAttribute('member_id'));
        // 获取任务钱包
        $wallet_task = $this->walletTaskService->getWalletInfo($request->getAttribute('member_id'));
        // 渲染视图
        return $this->render('task_worker/index', [
            'completed_count' => $completed_count,
            'success_rate' => $success_rate,
            'task_income' => $task_income,
            'wallet_task' => $wallet_task
        ]);
    }

    /**
     * 创建订单
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/task/worker/create')]
    public function create(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, TaskWorkerCreateRequest::class);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 调用服务层创建订单
        $result = $this->taskOrderService->task_worker_create($request->getAttribute('member_id'), $validate['task_type']);
        if (!$result->status) {
            return $this->fail($result->message);
        }
        return $this->success($result->message, $result->data);
    }

    /**
     * 查询订单
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/task/worker/query')]
    public function query(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, TaskWorkerQueryRequest::class);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 调用服务层获取订单
        $result = $this->taskWorkerService->query($request->getAttribute('member_id'), $validate['order_no']);
        if (!$result->status) {
            return $this->fail($result->message);
        }
        return $this->success($result->message, $result->data);
    }

    /**
     * 获取订单
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/task/worker/fetch')]
    public function fetch(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, TaskWorkerFetchRequest::class);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 调用服务层获取订单
        $result = $this->taskWorkerService->fetch($request->getAttribute('member_id'), $validate['order_no']);
        if (!$result->status) {
            return $this->fail($result->message);
        }
        return $this->success($result->message, $result->data);
    }

    /**
     * 提交订单
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/task/worker/submit')]
    public function submit(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, TaskWorkerSubmitRequest::class);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 调用服务层创建订单
        $result = $this->taskWorkerService->submit($request->getAttribute('member_id'), $validate['order_no'], $validate['result']);
        if (!$result->status) {
            return $this->fail($result->message);
        }
        return $this->success($result->message, $result->data);
    }

    /**
     * 提交订单
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/task/worker/cancel')]
    public function cancel(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, TaskWorkerCancelRequest::class);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 调用服务层创建订单
        $result = $this->taskWorkerService->cancel($request->getAttribute('member_id'), $validate['order_no']);
        if (!$result->status) {
            return $this->fail($result->message);
        }
        return $this->success($result->message, $result->data);
    }

    /**
     * 图片获取
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param string $image_id
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/task/worker/image/{image_id}')]
    public function image(RequestInterface $request, ResponseInterface $response, string $image_id): \Psr\Http\Message\ResponseInterface
    {
        // 获取任务图片数据
        $result = $this->taskWorkerService->image($image_id);
        if (!$result->status) {
            throw new NotFoundHttpException();
        }
        // 返回图片数据
        return $response->withHeader('Content-Type', 'image/png')->withBody(new SwooleStream($result->data));
    }
}