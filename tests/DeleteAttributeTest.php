<?php

namespace Spatie\RouteAttributes\Tests;

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
}
