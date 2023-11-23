<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteTestController;

class DeleteAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_a_delete_route()
    {
        $this->routeRegistrar->registerClass(DeleteTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(DeleteTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method');
    }

    /** @test */
    public function it_can_register_multiple_delete_routes()
    {
        $this->routeRegistrar->registerClass(DeleteMultipleTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(DeleteMultipleTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method')
            ->assertRouteRegistered(DeleteMultipleTestController::class, 'myDeleteMethod', 'delete', 'my-other-delete-method');
    }
}
