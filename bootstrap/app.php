<?php
declare(strict_types=1);

use BananaPHP\Providers\AppServiceProvider;
use BananaPHP\Providers\AuthServiceProvider;
use BananaPHP\Providers\DatabaseServiceProvider;
use BananaPHP\Providers\EventServiceProvider;
use DI\ContainerBuilder;

require_once __DIR__.'/autoload.php';

// Initialize container builder
$containerBuilder = new ContainerBuilder();

// Set up container configurations
$containerBuilder->addDefinitions([
    'config' => require __DIR__.'/../config/app.php',
]);

// Build the container
$container = $containerBuilder->build();

// Register service providers
$providers = [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    DatabaseServiceProvider::class,
    EventServiceProvider::class,
];

foreach ($providers as $provider) {
    $container->call([$provider, 'register']);
}

return $container;