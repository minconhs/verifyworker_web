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

use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\HttpServer\Router\Router;

Router::get('/.well-known/appspecific/com.chrome.devtools.json', function () {
    $response = \Hyperf\Support\make(ResponseInterface::class);
    return $response->raw('')->withStatus(204);
});

