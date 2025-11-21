<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PutMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PutTestController;

it('can register a put route', function () {
    $this->routeRegistrar->registerClass(PutTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(PutTestController::class, 'myPutMethod', 'put', 'my-put-method');
});

it('can register multiple put routes', function () {
    $this->routeRegistrar->registerClass(PutMultipleTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(PutMultipleTestController::class, 'myPutMethod', 'put', 'my-put-method')
        ->expectRouteRegistered(PutMultipleTestController::class, 'myPutMethod', 'put', 'my-other-put-method');
});
