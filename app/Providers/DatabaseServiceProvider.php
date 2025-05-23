<?php
declare(strict_types=1);

namespace BananaPHP\Providers;

use DI\Container;
use BananaPHP\Services\Database\QueryBuilder;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->set(QueryBuilder::class, function () use ($container) {
            return new QueryBuilder($container->get(Connection::class));
        });
    }
}