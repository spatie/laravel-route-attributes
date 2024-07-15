<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
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

class ResourceAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_resource_with_prefix()
    {
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
    }

    /** @test */
    public function it_can_register_resource_with_middleware()
    {
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
    }

    /** @test */
    public function it_can_register_resource_with_only_default_middleware()
    {
        $this->routeRegistrar->registerClass(ResourceTestOnlyController::class);

        $this
            ->assertRegisteredRoutesCount(3)
            ->assertRouteRegistered(
                ResourceTestOnlyController::class,
                controllerMethod: 'index',
                uri: 'posts',
                middleware: [AnotherTestMiddleware::class],
                name: 'posts.index'
            )
            ->assertRouteRegistered(
                ResourceTestOnlyController::class,
                controllerMethod: 'store',
                httpMethods: 'post',
                uri: 'posts',
                middleware: [AnotherTestMiddleware::class],
                name: 'posts.store'
            )
            ->assertRouteRegistered(
                ResourceTestOnlyController::class,
                controllerMethod: 'show',
                uri: 'posts/{post}',
                middleware: [AnotherTestMiddleware::class],
                name: 'posts.show'
            );
    }

    /** @test */
    public function it_can_register_resource_with_domain()
    {
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
    }

    /** @test */
    public function it_can_register_resource_with_names_as_string()
    {
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
    }

    /** @test */
    public function it_can_register_resource_with_names_as_array()
    {
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
    }

    /** @test */
    public function it_can_register_resource_with_all_methods()
    {
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
    }

    /** @test */
    public function it_can_register_resource_with_domain_option()
    {
        $this->routeRegistrar
            ->group(
                ['domain' => 'http://test'],
                fn () => $this->routeRegistrar->registerClass(ResourceTestFullController::class)
            );

        $this
            ->assertRegisteredRoutesCount(7);
    }

    /** @test */
    public function it_can_register_resource_with_only_few_methods()
    {
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
    }

    /** @test */
    public function it_can_register_resource_without_few_methods()
    {
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
    }

    /** @test */
    public function it_can_register_api_resource()
    {
        $this->routeRegistrar->registerClass(ApiResource1TestController::class);

        $this
            ->assertRegisteredRoutesCount(5)
            ->assertRouteRegistered(
                ApiResource1TestController::class,
                controllerMethod: 'index',
                uri: 'posts',
                name: 'posts.index'
            )
            ->assertRouteRegistered(
                ApiResource1TestController::class,
                controllerMethod: 'store',
                httpMethods: 'post',
                uri: 'posts',
                name: 'posts.store'
            )
            ->assertRouteRegistered(
                ApiResource1TestController::class,
                controllerMethod: 'show',
                uri: 'posts/{post}',
                name: 'posts.show'
            )
            ->assertRouteRegistered(
                ApiResource1TestController::class,
                controllerMethod: 'update',
                httpMethods: 'put',
                uri: 'posts/{post}',
                name: 'posts.update'
            )
            ->assertRouteRegistered(
                ApiResource1TestController::class,
                controllerMethod: 'destroy',
                httpMethods: 'delete',
                uri: 'posts/{post}',
                name: 'posts.destroy'
            );
    }

    /** @test */
    public function it_can_register_api_resource_2()
    {
        $this->routeRegistrar->registerClass(ApiResource2TestController::class);

        $this
            ->assertRegisteredRoutesCount(5)
            ->assertRouteRegistered(
                ApiResource2TestController::class,
                controllerMethod: 'index',
                uri: 'posts',
                name: 'posts.index'
            )
            ->assertRouteRegistered(
                ApiResource2TestController::class,
                controllerMethod: 'store',
                httpMethods: 'post',
                uri: 'posts',
                name: 'posts.store'
            )
            ->assertRouteRegistered(
                ApiResource2TestController::class,
                controllerMethod: 'show',
                uri: 'posts/{post}',
                name: 'posts.show'
            )
            ->assertRouteRegistered(
                ApiResource2TestController::class,
                controllerMethod: 'update',
                httpMethods: 'put',
                uri: 'posts/{post}',
                name: 'posts.update'
            )
            ->assertRouteRegistered(
                ApiResource2TestController::class,
                controllerMethod: 'destroy',
                httpMethods: 'delete',
                uri: 'posts/{post}',
                name: 'posts.destroy'
            );
    }

    /** @test */
    public function it_can_register_shallow_resource()
    {
        $this->routeRegistrar->registerClass(ResourceTestShallowController::class);

        $this
            ->assertRegisteredRoutesCount(7)
            ->assertRouteRegistered(
                ResourceTestShallowController::class,
                controllerMethod: 'index',
                uri: 'users/{user}/posts',
                name: 'users.posts.index'
            )
            ->assertRouteRegistered(
                ResourceTestShallowController::class,
                controllerMethod: 'create',
                uri: 'users/{user}/posts/create',
                name: 'users.posts.create'
            )
            ->assertRouteRegistered(
                ResourceTestShallowController::class,
                controllerMethod: 'store',
                httpMethods: 'post',
                uri: 'users/{user}/posts',
                name: 'users.posts.store'
            )
            ->assertRouteRegistered(
                ResourceTestShallowController::class,
                controllerMethod: 'show',
                uri: 'posts/{post}',
                name: 'posts.show'
            )
            ->assertRouteRegistered(
                ResourceTestShallowController::class,
                controllerMethod: 'edit',
                uri: 'posts/{post}/edit',
                name: 'posts.edit'
            )
            ->assertRouteRegistered(
                ResourceTestShallowController::class,
                controllerMethod: 'update',
                httpMethods: 'put',
                uri: 'posts/{post}',
                name: 'posts.update'
            )
            ->assertRouteRegistered(
                ResourceTestShallowController::class,
                controllerMethod: 'destroy',
                httpMethods: 'delete',
                uri: 'posts/{post}',
                name: 'posts.destroy'
            );
    }

    /** @test */
    public function it_can_register_resource_with_modified_parameters()
    {
        $this->routeRegistrar->registerClass(ResourceTestParametersController::class);

        $this
            ->assertRegisteredRoutesCount(7)
            ->assertRouteRegistered(
                ResourceTestParametersController::class,
                controllerMethod: 'show',
                uri: 'posts/{draft}',
                name: 'posts.show'
            )
            ->assertRouteRegistered(
                ResourceTestParametersController::class,
                controllerMethod: 'edit',
                uri: 'posts/{draft}/edit',
                name: 'posts.edit'
            )
            ->assertRouteRegistered(
                ResourceTestParametersController::class,
                controllerMethod: 'update',
                httpMethods: 'put',
                uri: 'posts/{draft}',
                name: 'posts.update'
            )
            ->assertRouteRegistered(
                ResourceTestParametersController::class,
                controllerMethod: 'destroy',
                httpMethods: 'delete',
                uri: 'posts/{draft}',
                name: 'posts.destroy'
            );
    }
}
