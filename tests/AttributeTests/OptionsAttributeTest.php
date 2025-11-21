<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\OptionsMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\OptionsTestController;

it('can register an options route', function () {
    $this->routeRegistrar->registerClass(OptionsTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(OptionsTestController::class, 'myOptionsMethod', 'options', 'my-options-method');
});

it('can register multiple options routes', function () {
    $this->routeRegistrar->registerClass(OptionsMultipleTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(OptionsMultipleTestController::class, 'myOptionsMethod', 'options', 'my-options-method')
        ->expectRouteRegistered(OptionsMultipleTestController::class, 'myOptionsMethod', 'options', 'my-other-options-method');
});
