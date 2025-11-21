<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\WithoutMiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\SkippedMiddleware;

it('can skip middleware added to class', function () {
    $this->routeRegistrar->registerClass(WithoutMiddlewareTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(
            WithoutMiddlewareTestController::class,
            controllerMethod: 'withoutMiddleware',
            uri: 'without-middleware',
            withoutMiddleware: [SkippedMiddleware::class],
        );
});
