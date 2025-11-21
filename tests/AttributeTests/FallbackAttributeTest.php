<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\FallbackTestController;

it('can register a route as fallback', function () {
    $this->routeRegistrar->registerClass(FallbackTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(
            controller: FallbackTestController::class,
            controllerMethod: 'myFallbackMethod',
            httpMethods: 'get',
            uri: 'my-fallback-method',
            isFallback: true
        );
});
