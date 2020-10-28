<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\AnyTestController;

class AnyAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_an_any_route()
    {
        $this->routeRegistrar->registerClass(AnyTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'head', 'my-any-method')
            ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'get', 'my-any-method')
            ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'post', 'my-any-method')
            ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'put', 'my-any-method')
            ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'patch', 'my-any-method')
            ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'delete', 'my-any-method')
            ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'options', 'my-any-method');
    }
}
