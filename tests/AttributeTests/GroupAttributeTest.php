<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GroupTestController;

class GroupAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_a_domain_on_the_url_of_every_method()
    {
        $this->routeRegistrar->registerClass(GroupTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                GroupTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-prefix/my-get-method',
                domain: 'my-subdomain.localhost'
            )
            ->assertRouteRegistered(
                GroupTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-prefix/my-post-method',
                domain: 'my-subdomain.localhost'
            )
            ->assertRouteRegistered(
                GroupTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-second-prefix/my-get-method',
                domain: 'my-second-subdomain.localhost'
            )
            ->assertRouteRegistered(
                GroupTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-second-prefix/my-post-method',
                domain: 'my-second-subdomain.localhost'
            );
    }
}
