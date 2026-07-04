<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\TaskPricing;

class TaskPricingService extends AbstractService
{
    public function __construct()
    {
        $this->model = new TaskPricing();
    }
}
