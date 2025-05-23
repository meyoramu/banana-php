<?php
declare(strict_types=1);

namespace BananaPHP\Providers;

use DI\Container;
use BananaPHP\Services\View\View;
use BananaPHP\Services\Router\Router;
use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\Database\Connection;
use Psr\Container\ContainerInterface;

class AppServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->set(ContainerInterface::class, $container);
        
        $container->set(Request::class, function () {
            return Request::createFromGlobals();
        });
        
        $container->set(Response::class, Response::class);
        
        $container->set(View::class, function () {
            return new View(__DIR__.'/../../resources/views');
        });
        
        $container->set(Connection::class, function () {
            return Connection::getInstance();
        });
        
        $container->set(Router::class, function () use ($container) {
            $webRoutes = require __DIR__.'/../../routes/web.php';
            $apiRoutes = require __DIR__.'/../../routes/api.php';
            return new Router(array_merge($webRoutes, $apiRoutes));
        });
    }
}