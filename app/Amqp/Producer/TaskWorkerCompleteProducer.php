<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

#[Producer(exchange: 'task_worker_completed', routingKey: 'task_worker_completed')]
class TaskWorkerCompleteProducer extends ProducerMessage
{
    public function __construct($data)
    {
        $this->payload = $data;
    }
}
