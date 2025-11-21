<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PostMultipleTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PostTestController;

it('can register a post route', function () {
    $this->routeRegistrar->registerClass(PostTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(PostTestController::class, 'myPostMethod', 'post', 'my-post-method');
});

it('can register multiple post routes', function () {
    $this->routeRegistrar->registerClass(PostMultipleTestController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(PostMultipleTestController::class, 'myPostMethod', 'post', 'my-post-method')
        ->assertRouteRegistered(PostMultipleTestController::class, 'myPostMethod', 'post', 'my-other-post-method');
});
