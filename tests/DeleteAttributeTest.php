<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteControllerTest;

class DeleteAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_a_delete_route()
    {
        $this->routeRegistrar->registerClass(DeleteControllerTest::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(DeleteControllerTest::class, 'myDeleteMethod', 'delete', 'my-delete-method');
    }
}
