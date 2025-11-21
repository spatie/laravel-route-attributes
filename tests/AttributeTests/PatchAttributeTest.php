<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PatchMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PatchTestController;

it('can register a patch route', function () {
    $this->routeRegistrar->registerClass(PatchTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(PatchTestController::class, 'myPatchMethod', 'patch', 'my-patch-method');
});

it('can register multiple patch routes', function () {
    $this->routeRegistrar->registerClass(PatchMultipleTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(PatchMultipleTestController::class, 'myPatchMethod', 'patch', 'my-patch-method')
        ->expectRouteRegistered(PatchMultipleTestController::class, 'myPatchMethod', 'patch', 'my-other-patch-method');
});
