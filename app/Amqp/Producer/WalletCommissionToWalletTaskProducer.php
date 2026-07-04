<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

#[Producer(exchange: 'wallet_commission_to_wallet_task', routingKey: 'wallet_commission_to_wallet_task')]
class WalletCommissionToWalletTaskProducer extends ProducerMessage
{
    public function __construct($data)
    {
        $this->payload = $data;
    }
}
