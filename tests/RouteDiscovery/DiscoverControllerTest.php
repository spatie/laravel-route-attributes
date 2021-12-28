<?php

namespace Spatie\RouteAttributes\Tests\RouteDiscovery;

use Illuminate\Support\Facades\Route;
use Spatie\RouteAttributes\RouteDiscovery\Discover;
use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\CustomMethod\CustomMethodController;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\SingleController\MyController;

class DiscoverControllerTest extends TestCase
{
    /** @test */
    public function it_can_discover_controller_in_a_directory()
    {
        Discover::controllers()
            ->useRootNamespace('Spatie\RouteAttributes\Tests\\')
            ->useBasePath($this->getTestPath())
            ->in($this->getTestPath('TestClasses/AutoDiscovery/SingleController'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my',
        );
    }

    public function it_can_use_a_prefix_when_discovering_routes()
    {
        Route::prefix('my-prefix')->group(function () {
            Discover::controllers()
                ->useRootNamespace('Spatie\RouteAttributes\Tests\\')
                ->useBasePath($this->getTestPath())
                ->in($this->getTestPath('TestClasses/AutoDiscovery/SingleController'));
        });

        $this->assertRegisteredRoutesCount(1);


        $this->assertRouteRegistered(
            MyController::class,
            controllerMethod: 'index',
            uri: 'my',
        );
    }

    /** @test */
    public function it_can_discover_controllers_with_custom_methods()
    {
        Discover::controllers()
            ->useRootNamespace('Spatie\RouteAttributes\Tests\\')
            ->useBasePath($this->getTestPath())
            ->in($this->getTestPath('TestClasses/AutoDiscovery/CustomMethod'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            CustomMethodController::class,
            controllerMethod: 'myCustomMethod',
            uri: 'custom-method/my-custom-method'
        );
    }
}
