<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\TestContractController;

class AttributesFromContractTest extends TestCase
{
    /** @test */
    public function it_can_found_attributes_in_contract()
    {
        $this->routeRegistrar->registerClass(TestContractController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(TestContractController::class, 'myAnyMethod', 'head', 'my-any-method')
            ->assertRouteRegistered(TestContractController::class, 'myAnyMethod', 'get', 'my-any-method')
            ->assertRouteRegistered(TestContractController::class, 'myAnyMethod', 'post', 'my-any-method')
            ->assertRouteRegistered(TestContractController::class, 'myAnyMethod', 'put', 'my-any-method')
            ->assertRouteRegistered(TestContractController::class, 'myAnyMethod', 'patch', 'my-any-method')
            ->assertRouteRegistered(TestContractController::class, 'myAnyMethod', 'delete', 'my-any-method')
            ->assertRouteRegistered(TestContractController::class, 'myAnyMethod', 'options', 'my-any-method');
    }
}
