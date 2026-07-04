<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\MemberLog;

class MemberLogService extends AbstractService
{
    public function __construct()
    {
        $this->model = new MemberLog();
    }
}
