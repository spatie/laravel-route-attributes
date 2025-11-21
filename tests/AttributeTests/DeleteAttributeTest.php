<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteTestController;

it('can register a delete route', function () {
    $this->routeRegistrar->registerClass(DeleteTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(DeleteTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method');
});

it('can register multiple delete routes', function () {
    $this->routeRegistrar->registerClass(DeleteMultipleTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(DeleteMultipleTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method')
        ->expectRouteRegistered(DeleteMultipleTestController::class, 'myDeleteMethod', 'delete', 'my-other-delete-method');
});
