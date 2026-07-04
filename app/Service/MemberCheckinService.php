<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\MemberCheckin;

class MemberCheckinService extends AbstractService
{
    public function __construct()
    {
        $this->model = new MemberCheckin();
    }
}
