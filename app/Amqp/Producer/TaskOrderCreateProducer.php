<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

#[Producer(exchange: 'task_order_create', routingKey: 'task_order_create')]
class TaskOrderCreateProducer extends ProducerMessage
{
    public function __construct($data)
    {
        $this->payload = $data;
    }
}
