<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Wallet;

class WalletService extends AbstractService
{
    public function __construct()
    {
        $this->model = new Wallet();
    }
}
