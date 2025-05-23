<?php
declare(strict_types=1);

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\Http\Router;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap/app.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$request = Request::createFromGlobals();
$router = new Router(require __DIR__.'/../routes/web.php');

try {
    $response = $router->dispatch($request);
} catch (Throwable $e) {
    $handler = new BananaPHP\Exceptions\Handler();
    $response = $handler->render($request, $e);
}

$response->send();