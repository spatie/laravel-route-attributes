<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Middleware;

use Closure;
use Illuminate\Http\Request;

class TestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
