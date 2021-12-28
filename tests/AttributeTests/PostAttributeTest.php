<?php

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PostTestController;

uses(TestCase::class);

it('can register a post route', function () {
    $this->routeRegistrar->registerClass(PostTestController::class);

    $this
        ->assertRegisteredRoutesCount(1)
        ->assertRouteRegistered(PostTestController::class, 'myPostMethod', 'post', 'my-post-method');
});
