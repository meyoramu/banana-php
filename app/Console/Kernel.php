<?php

namespace App;

use BananaPHP\Core\Application;
use BananaPHP\Core\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    protected array $middleware = [
        \App\Middleware\CorsMiddleware::class,
        \App\Middleware\RateLimitMiddleware::class,
    ];

    protected array $middlewareGroups = [
        'web' => [
            \App\Middleware\ValidationMiddleware::class,
        ],
        'api' => [
            \App\Middleware\AuthMiddleware::class,
        ],
    ];

    protected array $routeMiddleware = [
        'auth' => \App\Middleware\AuthMiddleware::class,
        'cors' => \App\Middleware\CorsMiddleware::class,
        'rate' => \App\Middleware\RateLimitMiddleware::class,
    ];

    public function bootstrap(): void
    {
        $this->registerProviders();
        $this->bootProviders();
        $this->registerMiddleware();
        $this->loadRoutes();
    }
}