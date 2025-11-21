<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PatchMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PatchTestController;

it('can register a patch route', function () {
    $this->routeRegistrar->registerClass(PatchTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(PatchTestController::class, 'myPatchMethod', 'patch', 'my-patch-method');
});

it('can register multiple patch routes', function () {
    $this->routeRegistrar->registerClass(PatchMultipleTestController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(PatchMultipleTestController::class, 'myPatchMethod', 'patch', 'my-patch-method')
        ->assertRouteRegistered(PatchMultipleTestController::class, 'myPatchMethod', 'patch', 'my-other-patch-method');
});
