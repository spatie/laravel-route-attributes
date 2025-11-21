<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GetMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GetTestController;

it('can register a get route', function () {
    $this->routeRegistrar->registerClass(GetTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(GetTestController::class, 'myGetMethod', 'get', 'my-get-method');
});

it('can register multiple get routes', function () {
    $this->routeRegistrar->registerClass(GetMultipleTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(GetMultipleTestController::class, 'myGetMethod', 'get', 'my-get-method')
        ->expectRouteRegistered(GetMultipleTestController::class, 'myGetMethod', 'get', 'my-other-get-method');
});
