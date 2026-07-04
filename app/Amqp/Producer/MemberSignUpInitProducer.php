<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

#[Producer(exchange: 'member_signup_init', routingKey: 'member_signup_init')]
class MemberSignUpInitProducer extends ProducerMessage
{
    public function __construct($data)
    {
        $this->payload = $data;
    }
}
