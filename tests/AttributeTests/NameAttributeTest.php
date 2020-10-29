<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\NameTestController;

class NameAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_a_prefix_name_for_all_routes()
    {
        $this->routeRegistrar->registerClass(NameTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                NameTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-get-method',
                name: 'my-name.my-get-method',
            )
            ->assertRouteRegistered(
                NameTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethod: 'post',
                uri: 'my-post-method',
                name: 'my-name.',
            );
    }
}
