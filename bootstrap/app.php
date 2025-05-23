<?php
declare(strict_types=1);

use BananaPHP\Providers\AppServiceProvider;
use BananaPHP\Providers\AuthServiceProvider;
use BananaPHP\Providers\DatabaseServiceProvider;
use BananaPHP\Providers\EventServiceProvider;

require_once __DIR__.'/autoload.php';

$container = new \DI\Container();

// Register service providers
$providers = [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    DatabaseServiceProvider::class,
    EventServiceProvider::class,
];

foreach ($providers as $provider) {
    (new $provider($container))->register();
}

return $container;