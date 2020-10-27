<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GetControllerTest;

class GetAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_a_get_route()
    {
        $this->routeRegistrar->registerClass(GetControllerTest::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(GetControllerTest::class, 'myGetMethod', 'get', 'my-get-method');
    }
}
