<?php
declare(strict_types=1);

use Dotenv\Dotenv;

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env(string $key, $default = null)
    {
        static $dotenv = null;
        
        if ($dotenv === null) {
            $dotenv = Dotenv::createImmutable(__DIR__.'/../');
            $dotenv->safeLoad();
        }

        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config(string $key, $default = null)
    {
        static $config = [];
        
        if (empty($config)) {
            $config = require __DIR__.'/../config/app.php';
        }

        return $config[$key] ?? $default;
    }
}