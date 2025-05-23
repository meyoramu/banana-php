<?php
declare(strict_types=1);

namespace BananaPHP\Services\Http;

use BananaPHP\Exceptions\Handler;
use BananaPHP\Middleware\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    private RouteCollection $routes;
    private array $middleware = [];

    public function __construct(array $routes)
    {
        $this->routes = new RouteCollection();
        
        foreach ($routes as $route) {
            $this->addRoute(
                $route['method'],
                $route['path'],
                $route['handler'],
                $route['middleware'] ?? []
            );
        }
    }

    public function addRoute(string $method, string $path, callable $handler, array $middleware = []): void
    {
        $route = new Route($path, ['_controller' => $handler]);
        $route->setMethods($method);
        
        $this->routes->add($method.$path, $route);
        $this->middleware[$method.$path] = $middleware;
    }

    public function dispatch(Request $request): Response
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        
        $matcher = new UrlMatcher($this->routes, $context);
        $parameters = $matcher->match($request->getPathInfo());
        
        $handler = $parameters['_controller'];
        $routeKey = $request->getMethod().$parameters['_route'];
        
        $middlewareStack = $this->middleware[$routeKey] ?? [];
        $middlewareStack[] = $handler;
        
        $pipeline = new Middleware\Pipeline();
        
        foreach ($middlewareStack as $middleware) {
            $pipeline->pipe(is_string($middleware) ? new $middleware() : $middleware);
        }
        
        return $pipeline->run($request);
    }
}