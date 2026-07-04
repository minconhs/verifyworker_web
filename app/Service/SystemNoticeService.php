<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\SystemNotice;

class SystemNoticeService extends AbstractService
{
    public function __construct()
    {
        $this->model = new SystemNotice();
    }
}
