<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\TaskClient;

class TaskClientService extends AbstractService
{
    public function __construct()
    {
        $this->model = new TaskClient();
    }
}
