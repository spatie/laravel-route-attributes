<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\middleware;

use Closure;
use Illuminate\Http\Request;

class Testmiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
