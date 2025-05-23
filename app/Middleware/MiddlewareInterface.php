<?php
declare(strict_types=1);

namespace BananaPHP\Middleware;

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response;
}