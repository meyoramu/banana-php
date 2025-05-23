<?php
declare(strict_types=1);

namespace BananaPHP\Providers;

use DI\Container;

interface ServiceProviderInterface
{
    /**
     * Register services to the container
     *
     * @param Container $container
     * @return void
     */
    public function register(Container $container): void;
}