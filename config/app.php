<?php
declare(strict_types=1);

return [
    'name' => 'BANANA-PHP',
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'providers' => [
        BananaPHP\Providers\AppServiceProvider::class,
        BananaPHP\Providers\AuthServiceProvider::class,
        BananaPHP\Providers\DatabaseServiceProvider::class,
        BananaPHP\Providers\EventServiceProvider::class,
    ],
];