<?php
declare(strict_types=1);

namespace BananaPHP\Providers;

use DI\Container;
use BananaPHP\Services\Database\QueryBuilder;
use BananaPHP\Services\Database\Connection;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->set(QueryBuilder::class, function () use ($container) {
            return new QueryBuilder($container->get(Connection::class));
        });
    }
}