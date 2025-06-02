<?php
namespace BananaPHP\Foundation;

class Application
{
    private $bindings = [];
    private $instances = [];

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
        $this->registerCoreBindings();
    }

    protected function registerCoreBindings()
    {
        $this->singleton(
            'BananaPHP\Contracts\Console\Kernel',
            'BananaPHP\Console\Kernel'
        );
    }

    public function make($abstract, array $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $concrete = $this->bindings[$abstract] ?? $abstract;

        if ($concrete === $abstract || is_callable($concrete)) {
            $object = new $concrete(...$parameters);
        } else {
            $object = $this->make($concrete, $parameters);
        }

        return $object;
    }

    public function singleton($abstract, $concrete = null)
    {
        $this->bindings[$abstract] = $concrete;
    }
}