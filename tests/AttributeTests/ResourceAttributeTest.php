<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestApiController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestDomainController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestExceptController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestFullController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestMiddlewareController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestNamesArrayController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestNamesStringController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestOnlyController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestPrefixController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

it('can register resource with prefix', function () {
    $this->routeRegistrar->registerClass(ResourceTestPrefixController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            ResourceTestPrefixController::class,
            controllerMethod: 'index',
            uri: 'api/v1/my-prefix/etc/posts',
            name: 'posts.index'
        )
        ->assertRouteRegistered(
            ResourceTestPrefixController::class,
            controllerMethod: 'show',
            uri: 'api/v1/my-prefix/etc/posts/{post}',
            name: 'posts.show'
        );
});

it('can register resource with middleware', function () {
    $this->routeRegistrar->registerClass(ResourceTestMiddlewareController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            ResourceTestMiddlewareController::class,
            controllerMethod: 'index',
            uri: 'posts',
            middleware: [TestMiddleware::class, OtherTestMiddleware::class],
            name: 'posts.index',
        )
        ->assertRouteRegistered(
            ResourceTestMiddlewareController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            middleware: [TestMiddleware::class, OtherTestMiddleware::class],
            name: 'posts.show',
        );
});

it('can register resource with domain', function () {
    $this->routeRegistrar->registerClass(ResourceTestDomainController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            ResourceTestDomainController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index',
            domain: 'my-subdomain.localhost'
        )
        ->assertRouteRegistered(
            ResourceTestDomainController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show',
            domain: 'my-subdomain.localhost'
        );
});

it('can register resource with names as string', function () {
    $this->routeRegistrar->registerClass(ResourceTestNamesStringController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            ResourceTestNamesStringController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'api.v1.posts.index',
        )
        ->assertRouteRegistered(
            ResourceTestNamesStringController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'api.v1.posts.show',
        );
});

it('can register resource with names as array', function () {
    $this->routeRegistrar->registerClass(ResourceTestNamesArrayController::class);

    $this
        ->assertRegisteredRoutesCount(2)
        ->assertRouteRegistered(
            ResourceTestNamesArrayController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.list',
        )
        ->assertRouteRegistered(
            ResourceTestNamesArrayController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.view',
        );
});

it('can register resource with all methods', function () {
    $this->routeRegistrar->registerClass(ResourceTestFullController::class);

    $this
        ->assertRegisteredRoutesCount(7)
        ->assertRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->assertRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'create',
            uri: 'posts/create',
            name: 'posts.create'
        )
        ->assertRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->assertRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->assertRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'edit',
            uri: 'posts/{post}/edit',
            name: 'posts.edit'
        )
        ->assertRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'posts/{post}',
            name: 'posts.update'
        )
        ->assertRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'posts/{post}',
            name: 'posts.destroy'
        );
});

it('can register resource with only few methods', function () {
    $this->routeRegistrar->registerClass(ResourceTestOnlyController::class);

    $this
        ->assertRegisteredRoutesCount(3)
        ->assertRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->assertRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->assertRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        );
});

it('can register resource without few methods', function () {
    $this->routeRegistrar->registerClass(ResourceTestExceptController::class);

    $this
        ->assertRegisteredRoutesCount(5)
        ->assertRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->assertRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'create',
            uri: 'posts/create',
            name: 'posts.create'
        )
        ->assertRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->assertRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->assertRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'edit',
            uri: 'posts/{post}/edit',
            name: 'posts.edit'
        );
});

it('can register api resource', function () {
    $this->routeRegistrar->registerClass(ResourceTestApiController::class);

    $this
        ->assertRegisteredRoutesCount(5)
        ->assertRouteRegistered(
            ResourceTestApiController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->assertRouteRegistered(
            ResourceTestApiController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->assertRouteRegistered(
            ResourceTestApiController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->assertRouteRegistered(
            ResourceTestApiController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'posts/{post}',
            name: 'posts.update'
        )
        ->assertRouteRegistered(
            ResourceTestApiController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'posts/{post}',
            name: 'posts.destroy'
        );
});
