<?php
namespace BananaPHP\Foundation;

class Application
{
    protected $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function make($abstract, array $parameters = [])
    {
        return new $abstract(...$parameters);
    }

    public function singleton($abstract, $concrete = null)
    {
        // Basic singleton implementation
        // Store the concrete implementation in a static property or registry
        static $instances = [];
        $instances[$abstract] = $concrete ?? $abstract;
    }
}