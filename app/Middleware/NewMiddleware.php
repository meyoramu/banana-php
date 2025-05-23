<?php
declare(strict_types=1);

namespace App\Middleware;

use BananaPHP\Middleware\MiddlewareInterface;
use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;

class NewMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        // Perform actions before passing to next middleware
        $response = $next($request);
        // Perform actions after getting response
        return $response;
    }
}