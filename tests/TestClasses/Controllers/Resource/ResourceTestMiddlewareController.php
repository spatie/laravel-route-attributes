<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Resource;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

#[Middleware([TestMiddleware::class, OtherTestMiddleware::class])]
#[Resource('posts', only: ['index', 'show'])]
class ResourceTestMiddlewareController
{
    public function index() {}

    public function show($id) {}
}
