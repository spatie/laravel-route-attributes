<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\InvokableRouteGetTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RouteGetTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RouteMiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RouteMultiVerbTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RouteNameTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RoutePostTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

it('can register a get route using Route attribute', function () {
    $this->routeRegistrar->registerClass(RouteGetTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(RouteGetTestController::class, 'myGetMethod', 'get', 'my-get-method');
});

it('can register a post route using Route attribute', function () {
    $this->routeRegistrar->registerClass(RoutePostTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(RoutePostTestController::class, 'myPostMethod', 'post', 'my-post-method');
});

it('can register a multi-verb route using Route attribute', function () {
    $this->routeRegistrar->registerClass(RouteMultiVerbTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(
            RouteMultiVerbTestController::class,
            'myMultiVerbMethod',
            ['get', 'post', 'delete'],
            'my-multi-verb-method'
        );
});

it('adds middleware to a method', function () {
    $this->routeRegistrar->registerClass(RouteMiddlewareTestController::class);

    $this->expectRouteRegistered(
        controller: RouteMiddlewareTestController::class,
        middleware: TestMiddleware::class,
    );
});

it('adds a route name to a method', function () {
    $this->routeRegistrar->registerClass(RouteNameTestController::class);

    $this->expectRouteRegistered(
        controller: RouteNameTestController::class,
        name: 'test-name',
    );
});

it('adds a route for an invokable', function () {
    $this->routeRegistrar->registerClass(InvokableRouteGetTestController::class);

    $this
        ->expectRegisteredRoutesCount(1)
        ->expectRouteRegistered(
            controller: InvokableRouteGetTestController::class,
            controllerMethod: InvokableRouteGetTestController::class,
            uri: 'my-invokable-route'
        );
});
