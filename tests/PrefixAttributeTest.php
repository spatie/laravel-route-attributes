<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PrefixTestController;

class PrefixAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_a_prefix_on_the_url_of_every_method()
    {
        $this->routeRegistrar->registerClass(PrefixTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                PrefixTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-prefix/my-get-method',
            )
            ->assertRouteRegistered(
                PrefixTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethod: 'post',
                uri: 'my-prefix/my-post-method',
            );
    }
}
