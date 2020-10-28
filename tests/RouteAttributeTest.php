<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteGetTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteMiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RoutePostTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteNameTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

class RouteAttributeTest extends TestCase
{
    protected RouteRegistrar $routeRegistrar;

    /** @test */
    public function the_route_annotation_can_register_a_get_route_()
    {
        $this->routeRegistrar->registerClass(RouteGetTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(RouteGetTestController::class, 'myGetMethod', 'get', 'my-get-method');
    }

    /** @test */
    public function the_route_annotation_can_register_a_post_route()
    {
        $this->routeRegistrar->registerClass(RoutePostTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(RoutePostTestController::class, 'myPostMethod', 'post', 'my-post-method');
    }

    /** @test */
    public function it_can_add_middleware_to_a_method()
    {
        $this->routeRegistrar->registerClass(RouteMiddlewareTestController::class);

        $this->assertRouteRegistered(
            controller: RouteMiddlewareTestController::class,
            middleware: TestMiddleware::class,
        );
    }

    /** @test */
    public function it_can_add_a_route_name_to_a_method()
    {
        $this->routeRegistrar->registerClass(RouteNameTestController::class);

        $this->assertRouteRegistered(
            controller: RouteNameTestController::class,
            name: 'test-name',
        );
    }
}
