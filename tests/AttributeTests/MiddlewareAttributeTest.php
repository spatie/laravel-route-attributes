<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\MiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

it('can apply middleware on each method of a controller', function () {
        $this->routeRegistrar->registerClass(MiddlewareTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                MiddlewareTestController::class,
                controllerMethod: 'singleMiddleware',
                uri: 'single-middleware',
                middleware: [TestMiddleware::class],
            )
            ->assertRouteRegistered(
                MiddlewareTestController::class,
                controllerMethod: 'multipleMiddleware',
                uri: 'multiple-middleware',
                middleware: [TestMiddleware::class, OtherTestMiddleware::class],
            );
});