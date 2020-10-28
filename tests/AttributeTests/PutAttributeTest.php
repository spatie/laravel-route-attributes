<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PutTestController;

class PutAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_a_put_route()
    {
        $this->routeRegistrar->registerClass(PutTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(PutTestController::class, 'myPutMethod', 'put', 'my-put-method');
    }
}
