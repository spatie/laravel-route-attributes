<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\RouteAttributesServiceProvider;
use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped\GroupTestController;

class ServiceProviderWithEmptyMiddlewareTest extends TestCase
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

        $app['config']->set('route-attributes.directories', [
            __DIR__.'/TestClasses/Controllers/Grouped' => [
                'prefix' => 'grouped',
                'middleware' => '',
                'namespace' => 'Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped',
            ],
        ]);
    }

    public function test_empty_middleware_string_does_not_cause_binding_resolution_exception(): void
    {
        $this->expectRegisteredRoutesCount(11);

        $this->expectRouteRegistered(
            GroupTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'grouped/my-get-method',
            middleware: ['test']
        );

        $this->expectRouteRegistered(
            GroupTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'grouped/my-post-method',
        );
    }
}
