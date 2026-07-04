<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\QueueException;

class QueueExceptionService extends AbstractService
{
    public function __construct()
    {
        $this->model = new QueueException();
    }
}
