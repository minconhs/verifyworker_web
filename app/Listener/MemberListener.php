<?php

namespace App\Listener;

use App\Amqp\Producer\MemberSigninLogProducer;
use App\Event\MemberSigninEvent;
use Hyperf\Amqp\Producer;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class MemberListener implements ListenerInterface
{
    #[Inject]
    protected Producer $producer;

    public function listen(): array
    {
        // 返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            MemberSigninEvent::class,
        ];
    }

    public function process(object $event): void
    {
        $this->producer->produce(new MemberSigninLogProducer($event));
    }
}