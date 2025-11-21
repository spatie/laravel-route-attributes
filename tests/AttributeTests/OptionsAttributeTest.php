<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\OptionsMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\OptionsTestController;

it('can register an options route', function () {
        $this->routeRegistrar->registerClass(OptionsTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(OptionsTestController::class, 'myOptionsMethod', 'options', 'my-options-method');
});

it('can register multiple options routes', function () {
        $this->routeRegistrar->registerClass(OptionsMultipleTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(OptionsMultipleTestController::class, 'myOptionsMethod', 'options', 'my-options-method')
            ->assertRouteRegistered(OptionsMultipleTestController::class, 'myOptionsMethod', 'options', 'my-other-options-method');
});