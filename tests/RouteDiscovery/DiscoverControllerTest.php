<?php

use Illuminate\Support\Facades\Route;
use Spatie\RouteAttributes\RouteDiscovery\Discover;
use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\CustomMethod\CustomMethodController;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\SingleController\MyController;


it('can discover controller in a directory', function () {
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
});

it('can discover controllers with custom methods', function () {
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
});

// Helpers
function it_can_use_a_prefix_when_discovering_routes()
{
    Route::prefix('my-prefix')->group(function () {
        Discover::controllers()
            ->useRootNamespace('Spatie\RouteAttributes\Tests\\')
            ->useBasePath(test()->getTestPath())
            ->in(test()->getTestPath('TestClasses/AutoDiscovery/SingleController'));
    });

    test()->assertRegisteredRoutesCount(1);


    test()->assertRouteRegistered(
        MyController::class,
        controllerMethod: 'index',
        uri: 'my',
    );
}
