<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DeleteTestController;

it('can register a delete route', function () {
    $this->routeRegistrar->registerClass(DeleteTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(DeleteTestController::class, 'myDeleteMethod', 'delete', 'my-delete-method');
});
