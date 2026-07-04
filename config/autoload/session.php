<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\Session\Handler;

return [
    'handler' => Handler\RedisHandler::class,
    'options' => [
        'connection' => 'default',
        'path' => BASE_PATH . '/runtime/session',
        'gc_maxlifetime' => 86400 * 15,
        'session_name' => 'SESSION_ID',
        'domain' => null,
        'cookie_lifetime' => 0,
        'cookie_same_site' => 'lax',
        'expire_on_close'  => true
    ],
];
