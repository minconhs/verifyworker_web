<?php

namespace App\Controller;

use App\Middleware\AuthMiddleware;
use App\Request\SettingsNoticeRequest;
use App\Request\TicketCreateRequest;
use App\Request\TicketReplyRequest;
use App\Service\TicketService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
#[Middleware(AuthMiddleware::class)]
class TicketController extends AbstractController
{
    #[Inject]
    protected TicketService $ticketService;

    /**
     * 工单列表
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/ticket')]
    public function index(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
// 获取分页参数
        $page = $request->query('page', 1);
        // 每页记录数，默认为5
        $per_page = $request->query('per_page', 10);
        // 获取筛选状态
        $status = $request->query('status');
        // 获取打开的工单数量
        $open_count = $this->ticketService->getOpenTicketCount($request->getAttribute('member_id'));
        // 获取处理中的工单数量
        $processing_count = $this->ticketService->getProcessingTicketCount($request->getAttribute('member_id'));
        // 获取回复的工单数量
        $reply_count = $this->ticketService->getReplyTicketCount($request->getAttribute('member_id'));
        // 获取关闭的工单数量
        $closed_count = $this->ticketService->getClosedTicketCount($request->getAttribute('member_id'));
        // 获取所有的工单记录数量
        $total_count = $open_count + $processing_count + $reply_count + $closed_count;
        // 获取工单记录列表
        $pagination = $this->ticketService->paginate($request->getAttribute('member_id'), $page, $per_page, ['status' => $status]);
        return $this->render('ticket/index', [
            'status' => $status,
            'open_count' => $open_count,
            'processing_count' => $processing_count,
            'reply_count' => $reply_count,
            'closed_count' => $closed_count,
            'total_count' => $total_count,
            'pagination' => $pagination
        ]);
    }

    /**
     * 工单详情
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param int $ticket_id
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/ticket/detail/{ticket_id:\d+}')]
    public function detail(RequestInterface $request, ResponseInterface $response, int $ticket_id): \Psr\Http\Message\ResponseInterface
    {
        // 获取工单详情
        $ticket = $this->ticketService->getTicketInfo($ticket_id, $request->getAttribute('member_id'));
        // 获取工单的消息记录
        $ticketMessages = $this->ticketService->getTicketMessages($ticket_id);
        return $this->render('ticket/detail', [
            'ticket' => $ticket,
            'messages' => $ticketMessages
        ]);
    }

    /**
     * 创建工单
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/ticket/create')]
    public function create_get(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 渲染创建工单页面
        return $this->render('ticket/create');
    }

    /**
     * 创建工单提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/ticket/create')]
    public function create_post(RequestInterface $request, ResponseInterface $response): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, TicketCreateRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error('/ticket/create', $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 创建工单
        $result = $this->ticketService->create($request->getAttribute('member_id'), $validate['subject'], $validate['description'], $validate['priority'], $validate['category']);
        if (!$result->status) {
            return $this->redirect_error('/ticket/create', $result->message);
        } else {
            return $this->redirect_success('/ticket', $result->message);
        }
    }

    /**
     * 回复工单提交
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param int $ticket_id
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[PostMapping('/ticket/reply/{ticket_id:\d+}')]
    public function reply(RequestInterface $request, ResponseInterface $response, int $ticket_id): \Psr\Http\Message\ResponseInterface
    {
        // 获取数据
        $data = $request->post();
        // 验证数据
        $validator = $this->validationService->validate($data, TicketReplyRequest::class);
        if ($validator->fails()) {
            return $this->redirect_error("/ticket/detail/{$ticket_id}", $validator->errors()->first(), $data);
        }
        // 获取请求参数
        $validate = $validator->validate();
        // 回复工单
        $result = $this->ticketService->reply($request->getAttribute('member_id'), $ticket_id, $validate['content']);
        if (!$result->status) {
            return $this->redirect_error("/ticket/detail/{$ticket_id}", $result->message);
        } else {
            return $this->redirect_success("/ticket/detail/{$ticket_id}", $result->message);
        }
    }


    /**
     * 关闭工单
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param int $ticket_id
     * @return \Psr\Http\Message\ResponseInterface
     */
    #[GetMapping('/ticket/close/{ticket_id:\d+}')]
    public function close(RequestInterface $request, ResponseInterface $response, int $ticket_id): \Psr\Http\Message\ResponseInterface
    {
        $result = $this->ticketService->close($request->getAttribute('member_id'), $ticket_id);
        if (!$result->status) {
            return $this->redirect_error("/ticket/detail/{$ticket_id}", $result->message);
        }
        return $this->redirect_success("/ticket", $result->message);
    }
}