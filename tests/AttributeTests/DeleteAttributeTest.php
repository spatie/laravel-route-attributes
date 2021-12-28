<?php

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteTestController;

uses(TestCase::class);

it('can register a delete route', function () {
    $this->routeRegistrar->registerClass(DeleteTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(DeleteTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method');
});
