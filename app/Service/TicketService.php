<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\BusinessException;
use App\Model\Ticket;
use App\Model\TicketMessage;
use Hyperf\Collection\Collection;
use Hyperf\DbConnection\Db;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;

class TicketService extends AbstractService
{
    public function __construct()
    {
        $this->model = new Ticket();
    }

    /**
     * 获取工单信息
     * @param int $ticket_id 工单ID
     * @param int $member_id 会员ID
     * @return Ticket
     */
    public function getTicketInfo(int $ticket_id, int $member_id): Ticket
    {
        $cache_key = "ticket_info_{$ticket_id}";
        $cache_value = $this->redis->get($cache_key);
        if ($cache_value) {
            return $this->model->forceFill(json_decode($cache_value, true));
        }
        // 从数据库中获取工单信息
        $ticket = $this->model->where('id', $ticket_id)->where('member_id', $member_id)->first();
        if (!$ticket) {
            throw new NotFoundHttpException();
        }
        // 将工单信息缓存到Redis中，设置过期时间为10分钟
        $this->redis->set($cache_key, 600, $ticket->toJson());
        // 返回工单信息
        return $ticket;
    }

    /**
     * 获取打开的工单数量
     * @param int $member_id
     * @return int 打开的工单数量
     */
    public function getOpenTicketCount(int $member_id): int
    {
        return $this->model->where('member_id', $member_id)->where('status', 'open')->count();
    }

    /**
     * 获取处理中的工单数量
     * @param int $member_id
     * @return int 处理中的工单数量
     */
    public function getProcessingTicketCount(int $member_id): int
    {
        return $this->model->where('member_id', $member_id)->where('status', 'processing')->count();
    }

    /**
     * 获取回复的工单数量
     * @param int $member_id
     * @return int 回复的工单数量
     */
    public function getReplyTicketCount(int $member_id): int
    {
        return $this->model->where('member_id', $member_id)->where('status', 'reply')->count();
    }

    /**
     * 获取关闭的工单数量
     * @param int $member_id
     * @return int 关闭的工单数量
     */
    public function getClosedTicketCount(int $member_id): int
    {
        return $this->model->where('member_id', $member_id)->where('status', 'closed')->count();
    }

    /**
     * 获取工单的消息记录
     * @param int $ticket_id 工单ID
     * @return Collection 消息记录列表
     */
    public function getTicketMessages(int $ticket_id): Collection
    {
        return TicketMessage::where('ticket_id', $ticket_id)->get();
    }

    /**
     * 创建工单
     * @param int $member_id 会员ID
     * @param string $subject 工单主题
     * @param string $description 工单描述
     * @param string $priority 工单优先级
     * @param string $category 工单类别
     * @return ResultService
     */
    public function create(int $member_id, string $subject, string $description, string $priority, string $category): ResultService
    {
        try {
            return Db::transaction(function () use ($member_id, $subject, $description, $priority, $category) {
                // 创建工单
                $ticket = new Ticket();
                $ticket->member_id = $member_id;
                $ticket->order_no = 'TK' .date('YmdHis') . rand(100000, 999999);
                $ticket->subject = $subject;
                $ticket->description = $description;
                $ticket->category = $category;
                $ticket->priority = $priority;
                $ticket->status = 'processing';
                if (!$ticket->save()) {
                    throw new BusinessException('Failed to create ticket, please try again later.');
                }
                // 创建工单消息
                $message = new TicketMessage();
                $message->ticket_id = $ticket->id;
                $message->sender = 'robot';
                $message->content = "Your ticket has been created successfully. Our support team will review your request and get back to you as soon as possible. Ticket ID: {$ticket->order_no}";
                if (!$message->save()) {
                    throw new BusinessException('Failed to create ticket, please try again later.');
                }
                return ResultService::success('Your ticket has been created successfully. Our support team will review your request and get back to you as soon as possible.');
            });
        } catch (BusinessException $e) {
            // 业务异常：正常返回
            return ResultService::failure($e->getMessage());
        } catch (\Throwable $e) {
            return ResultService::failure('System error, failed to create ticket, please try again later');
        }
    }

    /**
     * 回复工单
     * @param int $member_id 会员ID
     * @param int $ticket_id 工单ID
     * @param string $content 回复内容
     * @return ResultService
     */
    public function reply(int $member_id, int $ticket_id, string $content): ResultService
    {
        // 查询工单
        $ticket = Ticket::where('id', $ticket_id)->where('member_id', $member_id)->first();
        if (!$ticket) {
            return ResultService::failure('Ticket not found');
        }
        // 验证工单状态
        if ($ticket->status == 'closed') {
            return ResultService::failure('This ticket has been resolved or closed and cannot be replied to.');
        }
        // 更新工单状态为待处理
        $ticket->status = 'processing';
        if (!$ticket->save()) {
            return ResultService::failure('Failed to update ticket status, please try again later.');
        }
        // 创建工单消息
        $message = new TicketMessage();
        $message->ticket_id = $ticket_id;
        $message->sender = 'member';
        $message->content = $content;
        if (!$message->save()) {
            return ResultService::failure('Failed to create ticket message, please try again later.');
        }

        // 回复成功后清除工单详情缓存
        $this->redis->del("ticket_info_{$ticket_id}");

        return ResultService::success('Your reply has been submitted successfully. Our support team will review your message and get back to you as soon as possible.');
    }
    /**
     * 关闭工单
     * @param int $member_id 会员ID
     * @param int $ticket_id 工单ID
     * @return ResultService
     */
    public function close(int $member_id, int $ticket_id): ResultService
    {
        // 查询工单
        $ticket = Ticket::where('id', $ticket_id)->where('member_id', $member_id)->first();
        if (!$ticket) {
            return ResultService::failure('Ticket not found');
        }
        // 验证工单状态
        if ($ticket->status == 'closed') {
            return ResultService::failure('This ticket has already been closed.');
        }
        // 更新工单状态为已关闭
        $ticket->status = 'closed';
        if (!$ticket->save()) {
            return ResultService::failure('Failed to close the ticket, please try again later.');
        }

        // 关闭成功后清除工单详情缓存
        $this->redis->del("ticket_info_{$ticket_id}");

        return ResultService::success('Close Success.');
    }

}
