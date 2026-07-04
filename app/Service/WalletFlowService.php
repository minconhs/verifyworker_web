<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\WalletFlow;

class WalletFlowService extends AbstractService
{
    public function __construct()
    {
        $this->model = new WalletFlow();
    }
}
