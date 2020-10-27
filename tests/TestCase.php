<?php

namespace Spatie\RouteAttributes\Tests;

use Arr;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\RouteAttributes\RouteAttributesServiceProvider;
use Spatie\RouteAttributes\RouteRegistrar;

class TestCase extends Orchestra
{
    protected RouteRegistrar $routeRegistrar;

    public function setUp(): void
    {
        parent::setUp();

        $router = app()->router;

        $this->routeRegistrar = (new RouteRegistrar($router))->useBasePath($this->getTestPath());
    }

    protected function getPackageProviders($app)
    {
        return [
            RouteAttributesServiceProvider::class,
        ];
    }

    public function getTestPath(): string
    {
        return __DIR__;
    }

    public function assertRegisteredRoutesCount(int $expectedNumber): self
    {
        $actualNumber = $this->getRouteCollection()->count();

        $this->assertEquals($expectedNumber, $actualNumber);

        return $this;
    }

    public function assertRouteRegistered(
        string $controller,
        string $controllerMethod = 'myMethod',
        string $httpMethod = 'get',
        string $uri = 'my-method',
        string|array $middleware = [],
        ?string $name = null,
    ): self {
        if (! is_array($middleware)) {
            $middleware = Arr::wrap($middleware);
        }

        $routeRegistered = collect($this->getRouteCollection()->getRoutes())
            ->contains(function (Route $route) use ($name, $middleware, $controllerMethod, $controller, $uri, $httpMethod) {
                if (! in_array(strtoupper($httpMethod), $route->methods)) {
                    return false;
                }

                if ($route->uri() !== $uri) {
                    return false;
                }

                if (get_class($route->getController()) !== $controller) {
                    return false;
                }

                if ($route->getActionMethod() !== $controllerMethod) {
                    return false;
                }

                if (array_diff($route->middleware(), $middleware)) {
                    return false;
                }

                if ($route->getName() !== $name) {
                    return false;
                }

                return true;
            });

        $this->assertTrue($routeRegistered, 'The expected route was not registered');

        return $this;
    }

    protected function getRouteCollection(): RouteCollection
    {
        return app()->router->getRoutes();
    }
}
