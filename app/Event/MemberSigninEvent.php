<?php

namespace App\Event;

class MemberSigninEvent
{
    public int $member_id;

    public int $status;

    public string $status_message;

    public string $ip_address;

    public string $user_agent;

//    public function __construct(int $member_id, int $status, string $status_message, string $ip_address, string $user_agent)
//    {
//        $this->member_id      = $member_id;
//        $this->status         = $status;
//        $this->status_message = $status_message;
//        $this->ip_address     = $ip_address;
//        $this->user_agent     = $user_agent;
//    }
}