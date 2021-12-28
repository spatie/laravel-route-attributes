<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PatchTestController;

it('can register a patch route', function () {
    $this->routeRegistrar->registerClass(PatchTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(PatchTestController::class, 'myPatchMethod', 'patch', 'my-patch-method');
});
