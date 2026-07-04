<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\TicketMessage;

class TicketMessageService extends AbstractService
{
    public function __construct()
    {
        $this->model = new TicketMessage();
    }
}
