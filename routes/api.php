<?php
declare(strict_types=1);

use BananaPHP\Controllers\ApiController;
use BananaPHP\Middleware\ApiAuthMiddleware;
use BananaPHP\Middleware\RateLimitMiddleware;

return [
    [
        'method' => 'POST',
        'path' => '/api/login',
        'handler' => [ApiController::class, 'login'],
    ],
    [
        'method' => 'GET',
        'path' => '/api/user',
        'handler' => [ApiController::class, 'user'],
        'middleware' => [ApiAuthMiddleware::class],
    ],
    [
        'method' => 'GET',
        'path' => '/api/data',
        'handler' => [ApiController::class, 'data'],
        'middleware' => [ApiAuthMiddleware::class, RateLimitMiddleware::class],
    ],
];