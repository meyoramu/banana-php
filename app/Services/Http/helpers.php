<?php
declare(strict_types=1);

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;

if (!function_exists('app')) {
    function app(): \DI\Container
    {
        return $GLOBALS['container'] ?? require __DIR__.'/../../../bootstrap/app.php';
    }
}

if (!function_exists('request')) {
    function request(): Request
    {
        return app()->get(Request::class);
    }
}

if (!function_exists('response')) {
    function response(): Response
    {
        return app()->get(Response::class);
    }
}