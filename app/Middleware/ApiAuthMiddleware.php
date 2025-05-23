<?php
declare(strict_types=1);

namespace BananaPHP\Middleware;

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use BananaPHP\Services\Auth\JWTService;

class ApiAuthMiddleware implements MiddlewareInterface
{
    private JWTService $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle(Request $request, callable $next): Response
    {
        $token = $request->bearerToken();
        
        if (!$token || !$this->jwtService->validate($token)) {
            return Response::unauthorized('Invalid or missing authentication token');
        }

        return $next($request);
    }
}