<?php

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DomainTestController;

uses(TestCase::class);

it('can apply a domain on the url of every method', function () {
    $this->routeRegistrar->registerClass(DomainTestController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            DomainTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'my-get-method',
            domain: 'my-subdomain.localhost'
        )
        ->assertRouteRegistered(
            DomainTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'my-post-method',
            domain: 'my-subdomain.localhost'
        );
});
