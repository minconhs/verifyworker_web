<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\MemberCheckinStat;

class MemberCheckinStatsService extends AbstractService
{
    public function __construct()
    {
        $this->model = new MemberCheckinStat();
    }
}
