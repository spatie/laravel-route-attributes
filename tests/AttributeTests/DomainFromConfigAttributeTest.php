<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DomainFromConfigTestController;

it('can apply a domain on the url of every method', function () {
    config()->set('domains.test', 'config.localhost');
    $this->routeRegistrar->registerClass(DomainFromConfigTestController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(
            DomainFromConfigTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'my-get-method',
            domain: 'config.localhost'
        )
        ->expectRouteRegistered(
            DomainFromConfigTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'my-post-method',
            domain: 'config.localhost'
        );
});
