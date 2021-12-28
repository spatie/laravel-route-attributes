<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\OptionsTestController;

it('can register a options route', function () {
    $this->routeRegistrar->registerClass(OptionsTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(OptionsTestController::class, 'myOptionsMethod', 'options', 'my-options-method');
});
