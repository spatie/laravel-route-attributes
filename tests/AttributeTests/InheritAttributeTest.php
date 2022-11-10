<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\InheritGroupOverrideTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\InheritPrefixTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\InheritGroupTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\InheritPrefixOverrideTestController;

class InheritAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_properties_from_parent_group()
    {
        $this->routeRegistrar->registerClass(InheritGroupTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                InheritGroupTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-prefix/my-get-method',
                domain: 'my-subdomain.localhost'
            )
            ->assertRouteRegistered(
                InheritGroupTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-prefix/my-post-method',
                domain: 'my-subdomain.localhost'
            )
            ->assertRouteRegistered(
                InheritGroupTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-second-prefix/my-get-method',
                domain: 'my-second-subdomain.localhost'
            )
            ->assertRouteRegistered(
                InheritGroupTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-second-prefix/my-post-method',
                domain: 'my-second-subdomain.localhost'
            );
    }

    /** @test */
    public function it_can_override_parent_group()
    {
        $this->routeRegistrar->registerClass(InheritGroupOverrideTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                InheritGroupOverrideTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'new-prefix/my-get-method',
                domain: 'new-subdomain.localhost'
            )
            ->assertRouteRegistered(
                InheritGroupOverrideTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'new-prefix/my-post-method',
                domain: 'new-subdomain.localhost'
            );
    }

    /** @test */
    public function it_can_apply_properties_from_parent_prefix()
    {
        $this->routeRegistrar->registerClass(InheritPrefixTestController::class);

        $this
            ->assertRegisteredRoutesCount(3)
            ->assertRouteRegistered(
                InheritPrefixTestController::class,
                controllerMethod: 'myRootGetMethod',
                uri: 'my-prefix',
            )
            ->assertRouteRegistered(
                InheritPrefixTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-prefix/my-get-method',
            )
            ->assertRouteRegistered(
                InheritPrefixTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-prefix/my-post-method',
            );
    }

    /** @test */
    public function it_can_override_parent_prefix()
    {
        $this->routeRegistrar->registerClass(InheritPrefixOverrideTestController::class);

        $this
            ->assertRegisteredRoutesCount(3)
            ->assertRouteRegistered(
                InheritPrefixOverrideTestController::class,
                controllerMethod: 'myRootGetMethod',
                uri: 'new-prefix',
            )
            ->assertRouteRegistered(
                InheritPrefixOverrideTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'new-prefix/my-get-method',
            )
            ->assertRouteRegistered(
                InheritPrefixOverrideTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'new-prefix/my-post-method',
            );
    }
}
