<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteTestController;

it('can register a delete route', function () {
    $this->routeRegistrar->registerClass(DeleteTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(DeleteTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method');
});

it('can register multiple delete routes', function () {
    $this->routeRegistrar->registerClass(DeleteMultipleTestController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(DeleteMultipleTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method')
        ->assertRouteRegistered(DeleteMultipleTestController::class, 'myDeleteMethod', 'delete', 'my-other-delete-method');
});
