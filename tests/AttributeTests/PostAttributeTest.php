<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PostMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PostTestController;

it('can register a post route', function () {
    $this->routeRegistrar->registerClass(PostTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(PostTestController::class, 'myPostMethod', 'post', 'my-post-method');
});

it('can register multiple post routes', function () {
    $this->routeRegistrar->registerClass(PostMultipleTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(PostMultipleTestController::class, 'myPostMethod', 'post', 'my-post-method')
        ->expectRouteRegistered(PostMultipleTestController::class, 'myPostMethod', 'post', 'my-other-post-method');
});
