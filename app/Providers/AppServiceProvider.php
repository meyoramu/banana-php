<?php
declare(strict_types=1);

namespace BananaPHP\Providers;

use DI\Container;
use BananaPHP\Services\View\View;
use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\Database\Connection;
use BananaPHP\Services\Http\Router;

class AppServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        // Bind Request
        $container->set(Request::class, function () {
            return Request::createFromGlobals();
        });

        // Bind Response
        $container->set(Response::class, \DI\create(Response::class));

        // Bind View
        $container->set(View::class, function () {
            return new View(__DIR__.'/../../resources/views');
        });

        // Bind Database Connection
        $container->set(Connection::class, function () {
            return Connection::getInstance();
        });

        // Bind Router
        $container->set(Router::class, function () use ($container) {
            $webRoutes = require __DIR__.'/../../routes/web.php';
            $apiRoutes = require __DIR__.'/../../routes/api.php';
            return new Router(array_merge($webRoutes, $apiRoutes));
        });
    }
}