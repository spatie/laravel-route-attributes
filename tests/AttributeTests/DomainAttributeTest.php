<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DomainTestController;

class DomainAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_a_domain_on_the_url_of_every_method()
    {
        $this->routeRegistrar->registerClass(DomainTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                DomainTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-get-method',
                domain: 'my-subdomain.localhost'
            )
            ->assertRouteRegistered(
                DomainTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-post-method',
                domain: 'my-subdomain.localhost'
            );
    }
}
