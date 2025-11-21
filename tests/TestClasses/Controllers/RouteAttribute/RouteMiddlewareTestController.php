<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

class RouteMiddlewareTestController
{
    #[Route('get', 'my-method', middleware: TestMiddleware::class)]
    public function myMethod() {}
}
