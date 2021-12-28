<?php

namespace Spatie\RouteAttributes\Tests\RouteDiscovery;

use Illuminate\Routing\ViewController;
use Illuminate\Support\Facades\Route;
use Spatie\RouteAttributes\RouteDiscovery\Discover;
use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\SingleController\MyController;

class DiscoverViewsTest extends TestCase
{
    /** @test */
    public function it_can_discover_views_in_a_directory()
    {
        Discover::views()->in($this->getTestPath('TestClasses/resources/views'));

        $this->assertRegisteredRoutesCount(6);

        collect([
            '/',
            'home',
            'long-name',
            'contact',
            'nested',
            'nested/another',
        ])->each(function(string $uri) {
            $this->assertRouteRegistered(
                ViewController::class,
                controllerMethod: '\\' . ViewController::class,
                uri: $uri,
            );
        });
    }
}
