<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ApiResource1TestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ApiResource2TestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestDomainController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestExceptController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestFullController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestMiddlewareController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestNamesArrayController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestNamesStringController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestOnlyController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestParametersController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestPrefixController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource\ResourceTestShallowController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\AnotherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\TestMiddleware;

it('can register resource with prefix', function () {
    $this->routeRegistrar->registerClass(ResourceTestPrefixController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(
            ResourceTestPrefixController::class,
            controllerMethod: 'index',
            uri: 'api/v1/my-prefix/etc/posts',
            name: 'posts.index'
        )
        ->expectRouteRegistered(
            ResourceTestPrefixController::class,
            controllerMethod: 'show',
            uri: 'api/v1/my-prefix/etc/posts/{post}',
            name: 'posts.show'
        );
});

it('can register resource with middleware', function () {
    $this->routeRegistrar->registerClass(ResourceTestMiddlewareController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(
            ResourceTestMiddlewareController::class,
            controllerMethod: 'index',
            uri: 'posts',
            middleware: [TestMiddleware::class, OtherTestMiddleware::class],
            name: 'posts.index',
        )
        ->expectRouteRegistered(
            ResourceTestMiddlewareController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            middleware: [TestMiddleware::class, OtherTestMiddleware::class],
            name: 'posts.show',
        );
});

it('can register resource with only default middleware', function () {
    $this->routeRegistrar->registerClass(ResourceTestOnlyController::class);

    $this
        ->expectRegisteredRoutesCount(3)
        ->expectRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'index',
            uri: 'posts',
            middleware: [AnotherTestMiddleware::class],
            name: 'posts.index'
        )
        ->expectRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            middleware: [AnotherTestMiddleware::class],
            name: 'posts.store'
        )
        ->expectRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            middleware: [AnotherTestMiddleware::class],
            name: 'posts.show'
        );
});

it('can register resource with domain', function () {
    $this->routeRegistrar->registerClass(ResourceTestDomainController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(
            ResourceTestDomainController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index',
            domain: 'my-subdomain.localhost'
        )
        ->expectRouteRegistered(
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
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(
            ResourceTestNamesStringController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'api.v1.posts.index',
        )
        ->expectRouteRegistered(
            ResourceTestNamesStringController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'api.v1.posts.show',
        );
});

it('can register resource with names as array', function () {
    $this->routeRegistrar->registerClass(ResourceTestNamesArrayController::class);

    $this
        ->expectRegisteredRoutesCount(2)
        ->expectRouteRegistered(
            ResourceTestNamesArrayController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.list',
        )
        ->expectRouteRegistered(
            ResourceTestNamesArrayController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.view',
        );
});

it('can register resource with all methods', function () {
    $this->routeRegistrar->registerClass(ResourceTestFullController::class);

    $this
        ->expectRegisteredRoutesCount(7)
        ->expectRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->expectRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'create',
            uri: 'posts/create',
            name: 'posts.create'
        )
        ->expectRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->expectRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->expectRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'edit',
            uri: 'posts/{post}/edit',
            name: 'posts.edit'
        )
        ->expectRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'posts/{post}',
            name: 'posts.update'
        )
        ->expectRouteRegistered(
            ResourceTestFullController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'posts/{post}',
            name: 'posts.destroy'
        );
});

it('can register resource with domain option', function () {
    $this->routeRegistrar
        ->group(
            ['domain' => 'http://test'],
            fn () => $this->routeRegistrar->registerClass(ResourceTestFullController::class)
        );

    $this
        ->expectRegisteredRoutesCount(7);
});

it('can register resource with only few methods', function () {
    $this->routeRegistrar->registerClass(ResourceTestOnlyController::class);

    $this
        ->expectRegisteredRoutesCount(3)
        ->expectRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->expectRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->expectRouteRegistered(
            ResourceTestOnlyController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        );
});

it('can register resource without few methods', function () {
    $this->routeRegistrar->registerClass(ResourceTestExceptController::class);

    $this
        ->expectRegisteredRoutesCount(5)
        ->expectRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->expectRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'create',
            uri: 'posts/create',
            name: 'posts.create'
        )
        ->expectRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->expectRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->expectRouteRegistered(
            ResourceTestExceptController::class,
            controllerMethod: 'edit',
            uri: 'posts/{post}/edit',
            name: 'posts.edit'
        );
});

it('can register API resource', function () {
    $this->routeRegistrar->registerClass(ApiResource1TestController::class);

    $this
        ->expectRegisteredRoutesCount(5)
        ->expectRouteRegistered(
            ApiResource1TestController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->expectRouteRegistered(
            ApiResource1TestController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->expectRouteRegistered(
            ApiResource1TestController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->expectRouteRegistered(
            ApiResource1TestController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'posts/{post}',
            name: 'posts.update'
        )
        ->expectRouteRegistered(
            ApiResource1TestController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'posts/{post}',
            name: 'posts.destroy'
        );
});

it('can register API resource 2', function () {
    $this->routeRegistrar->registerClass(ApiResource2TestController::class);

    $this
        ->expectRegisteredRoutesCount(5)
        ->expectRouteRegistered(
            ApiResource2TestController::class,
            controllerMethod: 'index',
            uri: 'posts',
            name: 'posts.index'
        )
        ->expectRouteRegistered(
            ApiResource2TestController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'posts',
            name: 'posts.store'
        )
        ->expectRouteRegistered(
            ApiResource2TestController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->expectRouteRegistered(
            ApiResource2TestController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'posts/{post}',
            name: 'posts.update'
        )
        ->expectRouteRegistered(
            ApiResource2TestController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'posts/{post}',
            name: 'posts.destroy'
        );
});

it('can register shallow resource', function () {
    $this->routeRegistrar->registerClass(ResourceTestShallowController::class);

    $this
        ->expectRegisteredRoutesCount(7)
        ->expectRouteRegistered(
            ResourceTestShallowController::class,
            controllerMethod: 'index',
            uri: 'users/{user}/posts',
            name: 'users.posts.index'
        )
        ->expectRouteRegistered(
            ResourceTestShallowController::class,
            controllerMethod: 'create',
            uri: 'users/{user}/posts/create',
            name: 'users.posts.create'
        )
        ->expectRouteRegistered(
            ResourceTestShallowController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'users/{user}/posts',
            name: 'users.posts.store'
        )
        ->expectRouteRegistered(
            ResourceTestShallowController::class,
            controllerMethod: 'show',
            uri: 'posts/{post}',
            name: 'posts.show'
        )
        ->expectRouteRegistered(
            ResourceTestShallowController::class,
            controllerMethod: 'edit',
            uri: 'posts/{post}/edit',
            name: 'posts.edit'
        )
        ->expectRouteRegistered(
            ResourceTestShallowController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'posts/{post}',
            name: 'posts.update'
        )
        ->expectRouteRegistered(
            ResourceTestShallowController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'posts/{post}',
            name: 'posts.destroy'
        );
});

it('can register resource with modified parameters', function () {
    $this->routeRegistrar->registerClass(ResourceTestParametersController::class);

    $this
        ->expectRegisteredRoutesCount(7)
        ->expectRouteRegistered(
            ResourceTestParametersController::class,
            controllerMethod: 'show',
            uri: 'posts/{draft}',
            name: 'posts.show'
        )
        ->expectRouteRegistered(
            ResourceTestParametersController::class,
            controllerMethod: 'edit',
            uri: 'posts/{draft}/edit',
            name: 'posts.edit'
        )
        ->expectRouteRegistered(
            ResourceTestParametersController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'posts/{draft}',
            name: 'posts.update'
        )
        ->expectRouteRegistered(
            ResourceTestParametersController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'posts/{draft}',
            name: 'posts.destroy'
        );
});
