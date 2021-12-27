<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\NestedController\Nested\ChildController;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\NestedController\ParentController;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\RouteName\CustomRouteNameController;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\SingleController\MyController;

class AutoDiscoveryTest extends TestCase
{
    /** @test */
    public function it_can_automatically_discovery_a_simple_route()
    {
        $this
            ->routeRegistrar
            ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/SingleController'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'test-classes/auto-discovery/single-controller/my',
        );
    }

    /** @test */
    public function it_can_automatically_discovery_a_route_with_a_custom_name()
    {
        $this
            ->routeRegistrar
            ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/RouteName'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            CustomRouteNameController::class,
            controllerMethod: 'index',
            uri: 'test-classes/auto-discovery/route-name/custom-route-name',
            name: 'this-is-a-custom-name',
        );
    }

    /** @test */
    public function it_can_automatically_discovery_a_nested_route()
    {
        $this
            ->routeRegistrar
            ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/NestedController'));

        $this->assertRouteRegistered(
            ParentController::class,
            controllerMethod: 'index',
            uri: 'test-classes/auto-discovery/nested-controller/parent',
        );

        $this->assertRouteRegistered(
            ChildController::class,
            controllerMethod: 'index',
            uri: 'test-classes/auto-discovery/nested-controller/nested/child',
        );

        $this->assertRegisteredRoutesCount(2);
    }
}
