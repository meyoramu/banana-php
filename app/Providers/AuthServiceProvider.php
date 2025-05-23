<?php
declare(strict_types=1);

namespace BananaPHP\Providers;

use DI\Container;
use BananaPHP\Services\Auth\AuthService;
use BananaPHP\Services\Auth\JWTService;
use BananaPHP\Services\Auth\PasswordService;

class AuthServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->set(AuthService::class, \DI\autowire(AuthService::class));
        $container->set(JWTService::class, \DI\autowire(JWTService::class));
        $container->set(PasswordService::class, \DI\autowire(PasswordService::class));
    }
}