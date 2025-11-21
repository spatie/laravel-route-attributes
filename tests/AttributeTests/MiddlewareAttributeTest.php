<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\MiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

it('can apply middleware on each method of a controller', function () {
    $this->routeRegistrar->registerClass(MiddlewareTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(
            MiddlewareTestController::class,
            controllerMethod: 'singleMiddleware',
            uri: 'single-middleware',
            middleware: [TestMiddleware::class],
        )
        ->expectRouteRegistered(
            MiddlewareTestController::class,
            controllerMethod: 'multipleMiddleware',
            uri: 'multiple-middleware',
            middleware: [TestMiddleware::class, OtherTestMiddleware::class],
        );
});
