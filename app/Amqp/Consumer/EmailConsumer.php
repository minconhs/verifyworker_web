<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Service\EmailService;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Di\Annotation\Inject;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[Consumer(exchange: 'email', routingKey: 'email', queue: 'email_queue', name: "email", nums: 1)]
class EmailConsumer extends ConsumerMessage
{
    #[Inject]
    protected EmailService $emailService;

    #[Inject]
    protected LoggerInterface $logger;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        try {
            $this->emailService->send($data['email'], $data['subject'], $data['template']);
            return Result::ACK;
        } catch (TransportExceptionInterface $e) {
            $this->logger->error("邮件队列出现异常: " . $e->getMessage());
            return Result::ACK;
        }
    }
}
