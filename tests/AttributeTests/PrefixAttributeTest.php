<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PrefixTestController;

it('can apply a prefix on the url of every method', function () {
    $this->routeRegistrar->registerClass(PrefixTestController::class);

    $this
        ->expectRegisteredRoutesCount(3)
        ->expectRouteRegistered(
            PrefixTestController::class,
            controllerMethod: 'myRootGetMethod',
            uri: 'my-prefix',
        )
        ->expectRouteRegistered(
            PrefixTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'my-prefix/my-get-method',
        )
        ->expectRouteRegistered(
            PrefixTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'my-prefix/my-post-method',
        );
});
