<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PostControllerTest;

class PostAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_a_post_route()
    {
        $this->routeRegistrar->registerClass(PostControllerTest::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(PostControllerTest::class, 'myPostMethod', 'post', 'my-post-method');
    }
}
