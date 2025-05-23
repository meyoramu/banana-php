<?php
declare(strict_types=1);

namespace BananaPHP\Middleware;

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\Auth\AuthService;

class AuthMiddleware implements MiddlewareInterface
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request, callable $next): Response
    {
        if (!$this->authService->check()) {
            return Response::redirect('/login');
        }

        return $next($request);
    }
}