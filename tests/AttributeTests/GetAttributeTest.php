<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\GetTestController;

it('can register a get route', function () {
    $this->routeRegistrar->registerClass(GetTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(GetTestController::class, 'myGetMethod', 'get', 'my-get-method');
});
