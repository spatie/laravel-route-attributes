<?php

namespace AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\WithTrashedTestController;

class WithTrashedAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_with_trashed_on_a_controller(): void
    {
        $this->routeRegistrar->registerClass(WithTrashedTestController::class);

        $this
            ->assertRegisteredRoutesCount(3)
            ->assertRouteRegistered(
                WithTrashedTestController::class,
                controllerMethod: 'withTrashedRoute',
                httpMethods: 'get',
                uri: 'with-trashed-test-method/{param}',
                withTrashed: true,
            )
            ->assertRouteRegistered(
                WithTrashedTestController::class,
                controllerMethod: 'withoutTrashedRoute',
                httpMethods: 'get',
                uri: 'with-trashed-test-method-2/{param}',
                withTrashed: false,
            )
            // registered through
            ->assertRouteRegistered(
                WithTrashedTestController::class,
                controllerMethod: 'noWithTrashedAttributeRoute',
                httpMethods: 'get',
                uri: 'with-trashed-test-method-3/{param}',
                withTrashed: true,
            )
        ;
    }
}
