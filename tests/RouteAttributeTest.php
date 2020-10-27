<?php

namespace Spatie\RouteAttributes\Tests;

use Illuminate\Routing\Router;
use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\GetRouteTestController;
use Spatie\RouteAttributes\Tests\TestClasses\PostRouteTestController;

class RouteAttributeTest extends TestCase
{
    protected RouteRegistrar $routeRegistrar;

    protected Router $router;

    public function setUp(): void
    {
        parent::setUp();

        $this->router = app()->router;

        $this->routeRegistrar = (new RouteRegistrar($this->router))->useBasePath($this->getTestPath());
    }

    /** @test */
    public function it_can_register_a_get_route()
    {
        $this->routeRegistrar->registerClass(GetRouteTestController::class);

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered('get', 'my-get-method-route', GetRouteTestController::class, 'myGetMethod');
    }

    /** @test */
    public function it_can_register_a_post_route()
    {
        $this->routeRegistrar->registerClass(PostRouteTestController::class);

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered('post', 'my-post-method-route', PostRouteTestController::class, 'myPostMethod');
    }
}
