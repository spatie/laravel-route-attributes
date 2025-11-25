<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\RouteAttributesServiceProvider;
use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped\GroupPrefixTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped\GroupResourceTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped\GroupResourceTestPrefixController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped\GroupTestController;

class ServiceProviderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->routeRegistrar = app(RouteRegistrar::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            RouteAttributesServiceProvider::class,
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('route-attributes.middleware', ['SomeMiddleware']);
        $app['config']->set('route-attributes.directories', [
            __DIR__.'/TestClasses/Controllers/Grouped' => [
                'prefix' => 'grouped',
                'middleware' => 'api',
                'namespace' => 'Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped',
            ],
        ]);
    }

    public function test_the_provider_can_register_group_of_directories(): void
    {
        $this->expectRegisteredRoutesCount(11);

        $this->expectRouteRegistered(
            GroupTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'grouped/my-get-method',
            middleware: ['SomeMiddleware', 'api', 'test']
        );

        $this->expectRouteRegistered(
            GroupTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'grouped/my-post-method',
            middleware: ['SomeMiddleware', 'api']
        );

        $this->expectRouteRegistered(
            GroupResourceTestController::class,
            controllerMethod: 'index',
            httpMethods: 'get',
            uri: 'grouped/posts',
            middleware: ['SomeMiddleware','api'],
            name: 'posts.index'
        );

        $this->expectRouteRegistered(
            GroupResourceTestController::class,
            controllerMethod: 'store',
            httpMethods: 'post',
            uri: 'grouped/posts',
            middleware: ['SomeMiddleware','api'],
            name: 'posts.store'
        );

        $this->expectRouteRegistered(
            GroupResourceTestController::class,
            controllerMethod: 'show',
            httpMethods: 'get',
            uri: 'grouped/posts/{post}',
            middleware: ['SomeMiddleware','api'],
            name: 'posts.show'
        );

        $this->expectRouteRegistered(
            GroupResourceTestController::class,
            controllerMethod: 'update',
            httpMethods: 'put',
            uri: 'grouped/posts/{post}',
            middleware: ['SomeMiddleware','api'],
            name: 'posts.update'
        );

        $this->expectRouteRegistered(
            GroupResourceTestController::class,
            controllerMethod: 'destroy',
            httpMethods: 'delete',
            uri: 'grouped/posts/{post}',
            middleware: ['SomeMiddleware','api'],
            name: 'posts.destroy'
        );

        $this->expectRouteRegistered(
            GroupResourceTestPrefixController::class,
            controllerMethod: 'index',
            httpMethods: 'get',
            uri: 'grouped/api/v1/my-prefix/etc/posts',
            middleware: ['SomeMiddleware','api'],
            name: 'prefixed_posts.index'
        );

        $this->expectRouteRegistered(
            GroupResourceTestPrefixController::class,
            controllerMethod: 'show',
            httpMethods: 'get',
            uri: 'grouped/api/v1/my-prefix/etc/posts/{post}',
            middleware: ['SomeMiddleware','api'],
            name: 'prefixed_posts.show'
        );

        $this->expectRouteRegistered(
            GroupPrefixTestController::class,
            controllerMethod: 'myGetMethod',
            httpMethods: 'get',
            uri: 'grouped/my-prefix/my-prefix-get-method',
            middleware: ['SomeMiddleware','api'],
        );

        $this->expectRouteRegistered(
            GroupPrefixTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'grouped/my-prefix/my-prefix-post-method',
            middleware: ['SomeMiddleware','api'],
        );
    }
}
