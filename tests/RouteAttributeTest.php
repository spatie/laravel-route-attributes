<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GetRouteTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\MiddlewareRouteTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PostRouteTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteNameTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

class RouteAttributeTest extends TestCase
{
    protected RouteRegistrar $routeRegistrar;

    public function setUp(): void
    {
        parent::setUp();

        $router = app()->router;

        $this->routeRegistrar = (new RouteRegistrar($router))->useBasePath($this->getTestPath());
    }

    /** @test */
    public function it_can_register_a_get_route()
    {
        $this->routeRegistrar->registerClass(GetRouteTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(GetRouteTestController::class, 'myGetMethod', 'get', 'my-get-method');
    }

    /** @test */
    public function it_can_register_a_post_route()
    {
        $this->routeRegistrar->registerClass(PostRouteTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(PostRouteTestController::class, 'myPostMethod', 'post', 'my-post-method');
    }

    /** @test */
    public function it_can_add_middleware_to_a_method()
    {
        $this->routeRegistrar->registerClass(MiddlewareRouteTestController::class);

        $this->assertRouteRegistered(
            controller: MiddlewareRouteTestController::class,
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
