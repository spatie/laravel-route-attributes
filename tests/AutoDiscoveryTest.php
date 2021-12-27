<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\SingleController\MyController;

class AutoDiscoveryTest extends TestCase
{
    /** @test */
    public function it_can_automatically_discovery_a_route()
    {
        $this
            ->routeRegistrar
            ->registerDirectory($this->getTestPath('TestClasses/AutoDiscovery/SingleController'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'simple',
        );
    }
}
