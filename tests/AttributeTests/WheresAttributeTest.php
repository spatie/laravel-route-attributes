<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\MiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\WheresTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

class WheresAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_where_on_each_method_of_a_controller()
    {
        $this->routeRegistrar->registerClass(WheresTestController::class);

        $this
            ->assertRegisteredRoutesCount(3)
            ->assertRouteRegistered(
                WheresTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-get-method/{param}',
                wheres: ['param' => '[0-9]+']
            )
            ->assertRouteRegistered(
                WheresTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-post-method/{param}',
                wheres: ['param' => '[0-9]+']
            );
    }

    /** @test */
    public function it_can_apply_where_on_a_method()
    {
        $this->routeRegistrar->registerClass(WheresTestController::class);

        $this
            ->assertRegisteredRoutesCount(3)
            ->assertRouteRegistered(
                WheresTestController::class,
                controllerMethod: 'myWhereMethod',
                uri: 'my-where-method/{param}/{param2}',
                wheres: ['param' => '[0-9]+', 'param2' => '[a-zA-Z]+']
            );
    }
}
