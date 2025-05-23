<?php
declare(strict_types=1);

namespace BananaPHP\Providers;

use DI\Container;
use BananaPHP\Events\EventManager;

class EventServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->set(EventManager::class, function () {
            return new EventManager();
        });
    }
}