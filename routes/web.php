<?php
declare(strict_types=1);

use BananaPHP\Controllers\HomeController;
use BananaPHP\Middleware\AuthMiddleware;

return [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => [HomeController::class, 'index'],
    ],
    [
        'method' => 'GET',
        'path' => '/about',
        'handler' => [HomeController::class, 'about'],
    ],
    [
        'method' => 'GET',
        'path' => '/dashboard',
        'handler' => [DashboardController::class, 'index'],
        'middleware' => [AuthMiddleware::class],
    ],
];