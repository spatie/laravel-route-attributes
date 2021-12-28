<?php

use Illuminate\Support\Facades\Route;
use Spatie\RouteAttributes\RouteDiscovery\Discover;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\CustomMethod\CustomMethodController;
use Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\SingleController\MyController;

it('can discover controller in a directory', function () {
    Discover::controllers()
        ->useRootNamespace('Spatie\RouteAttributes\Tests\\')
        ->useBasePath($this->getTestPath())
        ->in($this->getTestPath('TestClasses/AutoDiscovery/SingleController'));

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
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

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
        CustomMethodController::class,
        controllerMethod: 'myCustomMethod',
        uri: 'custom-method/my-custom-method'
    );
});

it('can use a prefix when discovering routes', function() {
    Route::prefix('my-prefix')->group(function () {
        Discover::controllers()
            ->useRootNamespace('Spatie\RouteAttributes\Tests\\')
            ->useBasePath(test()->getTestPath())
            ->in(test()->getTestPath('TestClasses/AutoDiscovery/SingleController'));
    });

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
        MyController::class,
        controllerMethod: 'index',
        uri: 'my-prefix/my',
    );
});
