<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\SkippedMiddleware;

class WithoutMiddlewareTestController
{
    #[Route('get', 'without-middleware', withoutMiddleware: SkippedMiddleware::class)]
    public function withoutMiddleware() {}
}
