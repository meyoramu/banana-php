<?php
declare(strict_types=1);

use BananaPHP\Providers\AppServiceProvider;
use BananaPHP\Providers\AuthServiceProvider;
use BananaPHP\Providers\DatabaseServiceProvider;
use BananaPHP\Providers\EventServiceProvider;
use DI\ContainerBuilder;

require __DIR__.'/../vendor/autoload.php';

// Load environment variables
if (file_exists(__DIR__.'/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->safeLoad();
}

// Initialize container builder
$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(false);

// Add definitions
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