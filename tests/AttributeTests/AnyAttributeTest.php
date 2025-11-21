<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\AnyTestController;

it('can register an any route', function () {
    $this->routeRegistrar->registerClass(AnyTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'head', 'my-any-method')
        ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'get', 'my-any-method')
        ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'post', 'my-any-method')
        ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'put', 'my-any-method')
        ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'patch', 'my-any-method')
        ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'delete', 'my-any-method')
        ->assertRouteRegistered(AnyTestController::class, 'myAnyMethod', 'options', 'my-any-method');
});
