<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\MemberSigninLogProducer;
use App\Exception\BusinessException;
use App\Model\MemberLog;
use App\Model\QueueFailedMessage;
use App\Service\IpinfoService;
use App\Service\UserAgentService;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'member_signin_log', routingKey: 'member_signin_log', queue: 'member_signin_log_queue', name: "MemberSigninLogConsumer", nums: 1)]
class MemberSigninLogConsumer extends ConsumerMessage
{
    #[Inject]
    protected IpinfoService $ipinfoService;

    #[Inject]
    protected UserAgentService $userAgentService;

    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取会员ID
        $member_id = $data['member_id'];
        // 获取登录IP
        $ip_address = $data['ip_address'];
        // 获取UA代理
        $user_agent = $data['user_agent'];
        // 获取登录状态
        $status = $data['status'];
        // 获取状态信息
        $status_message = $data['status_message'];

        try {
            // 查询登录日志中是否有当前IP地址
            $member_log = MemberLog::where('ip_address', $ip_address)->first();
            if ($member_log) {
                $location = $member_log->location;
            } else {
                // 获取登录地点
                $location = $this->ipinfoService->getLocation($ip_address);
            }
            // 获取操作系统
            $os = $this->userAgentService->getOs($user_agent);
            // 获取登录浏览器
            $browser = $this->userAgentService->getBrowser($user_agent);

            # 写入登录日志
            $memberLoginHistory = new MemberLog();
            $memberLoginHistory->member_id = $member_id;
            $memberLoginHistory->ip_address = $ip_address;
            $memberLoginHistory->location = $location;
            $memberLoginHistory->system_os = $os;
            $memberLoginHistory->browser = $browser;
            $memberLoginHistory->user_agent = $user_agent;
            $memberLoginHistory->status = $status;
            $memberLoginHistory->status_message = $status_message;
            if (!$memberLoginHistory->save()) {
                throw new BusinessException('Member login log failed to save');
            }

            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            $this->logger->error('MemberSigninLogConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('MemberSigninLogConsumerException,Retry limit reached, write failed.');
                }

                // 完成消费
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $member_signin_log_producer = new MemberSigninLogProducer($data);
            // 发送到队列
            $this->producer->produce($member_signin_log_producer);

            return Result::ACK;
        }
    }
}
