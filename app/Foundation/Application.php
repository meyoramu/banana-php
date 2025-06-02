<?php
namespace BananaPHP\Foundation;

class Application
{
    private $bindings = [];
    private $instances = [];
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
        $this->registerCoreBindings();
        $this->instance(Application::class, $this);
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
        // Return if already resolved
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Get the concrete implementation
        $concrete = $this->bindings[$abstract] ?? $abstract;

        // Special case for when we're making the Application itself
        if ($concrete === Application::class) {
            return $this;
        }

        // Build the instance with dependencies
        $reflector = new \ReflectionClass($concrete);
        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            if (!$parameter->hasType()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \RuntimeException("Cannot resolve parameter {$parameter->getName()} without type hint");
                }
                continue;
            }

            $type = $parameter->getType();
            if ($type instanceof \ReflectionNamedType && $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \RuntimeException("Cannot resolve built-in type {$type->getName()} for parameter {$parameter->getName()}");
                }
                continue;
            }

            $dependency = $type->getName();
            $dependencies[] = $this->make($dependency);
        }

        return $reflector->newInstanceArgs($dependencies);
    }

    public function singleton($abstract, $concrete = null)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function instance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }
}