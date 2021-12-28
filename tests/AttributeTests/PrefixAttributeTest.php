<?php

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PrefixTestController;


it('can apply a prefix on the url of every method', function () {
    $this->routeRegistrar->registerClass(PrefixTestController::class);

    $this
        ->assertRegisteredRoutesCount(3)
        ->assertRouteRegistered(
            PrefixTestController::class,
            controllerMethod: 'myRootGetMethod',
            uri: 'my-prefix',
        )
        ->assertRouteRegistered(
            PrefixTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'my-prefix/my-get-method',
        )
        ->assertRouteRegistered(
            PrefixTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'my-prefix/my-post-method',
        );
});
