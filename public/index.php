<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| BANANA-PHP Framework Entry Point
|--------------------------------------------------------------------------
|
| This file serves as the entry point for all HTTP requests to your
| BANANA-PHP application. It bootstraps the framework and handles
| the incoming request through the application kernel.
|
*/

define('BANANA_START', microtime(true));

// Register the Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Bootstrap the application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle the request through the kernel
$kernel = $app->make(\App\Kernel::class);

$response = $kernel->handle(
    $request = \BananaPHP\Http\Request::createFromGlobals()
);

$response->send();

$kernel->terminate($request, $response);