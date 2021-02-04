<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\MiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

class MiddlewareAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_middleware_on_each_method_of_a_controller()
    {
        $this->routeRegistrar->registerClass(MiddlewareTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                MiddlewareTestController::class,
                controllerMethod: 'singleMiddleware',
                uri: 'single-middleware',
                middleware: [TestMiddleware::class],
            )
            ->assertRouteRegistered(
                MiddlewareTestController::class,
                controllerMethod: 'multipleMiddleware',
                uri: 'multiple-middleware',
                middleware: [TestMiddleware::class, OtherTestMiddleware::class],
            );
    }
}
