<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PutMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PutTestController;

it('can register a put route', function () {
    $this->routeRegistrar->registerClass(PutTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(PutTestController::class, 'myPutMethod', 'put', 'my-put-method');
});

it('can register multiple put routes', function () {
    $this->routeRegistrar->registerClass(PutMultipleTestController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(PutMultipleTestController::class, 'myPutMethod', 'put', 'my-put-method')
        ->assertRouteRegistered(PutMultipleTestController::class, 'myPutMethod', 'put', 'my-other-put-method');
});
