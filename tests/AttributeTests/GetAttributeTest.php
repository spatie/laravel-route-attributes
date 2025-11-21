<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GetMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GetTestController;

it('can register a get route', function () {
    $this->routeRegistrar->registerClass(GetTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(GetTestController::class, 'myGetMethod', 'get', 'my-get-method');
});

it('can register multiple get routes', function () {
    $this->routeRegistrar->registerClass(GetMultipleTestController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(GetMultipleTestController::class, 'myGetMethod', 'get', 'my-get-method')
        ->assertRouteRegistered(GetMultipleTestController::class, 'myGetMethod', 'get', 'my-other-get-method');
});
