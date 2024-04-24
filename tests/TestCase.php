<?php

namespace Spatie\RouteAttributes\Tests;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Arr;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\AnotherTestMiddleware;

class TestCase extends Orchestra
{
    protected RouteRegistrar $routeRegistrar;

    public function setUp(): void
    {
        parent::setUp();

        $router = app()->router;

        $this->routeRegistrar = (new RouteRegistrar($router))
            ->useBasePath($this->getTestPath())
            ->useMiddleware([AnotherTestMiddleware::class])
            ->useRootNamespace('Spatie\RouteAttributes\Tests\\');
    }

    public function getTestPath(string $directory = null): string
    {
        return __DIR__ . ($directory ? DIRECTORY_SEPARATOR . $directory : '');
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
        string | array $httpMethods = ['get'],
        string $uri = 'my-method',
        string | array $middleware = [],
        ?string $name = null,
        ?string $domain = null,
        ?array $wheres = [],
        ?bool $isFallback = false,
        ?bool $enforcesScopedBindings = false,
        ?bool $preventsScopedBindings = false,
        ?array $defaults = [],
        ?bool $withTrashed = false,
    ): self {
        if (! is_array($middleware)) {
            $middleware = Arr::wrap($middleware);
        }

        $routeRegistered = collect($this->getRouteCollection()->getRoutes())
            ->contains(function (Route $route) use ($name, $middleware, $controllerMethod, $controller, $uri, $httpMethods, $domain, $wheres, $isFallback, $enforcesScopedBindings, $preventsScopedBindings, $defaults, $withTrashed) {
                foreach (Arr::wrap($httpMethods) as $httpMethod) {
                    if (! in_array(strtoupper($httpMethod), $route->methods)) {
                        return false;
                    }
                }

                if ($route->uri() !== $uri) {
                    return false;
                }

                $routeController = $route->getAction(0) ?? get_class($route->getController());
                if ($routeController !== $controller) {
                    return false;
                }

                $routeMethod = $route->getAction(1) ?? $route->getActionMethod();
                if ($routeMethod !== $controllerMethod) {
                    return false;
                }

                if (array_diff(array_merge($middleware, $this->routeRegistrar->middleware()), $route->middleware())) {
                    return false;
                }

                if ($route->getName() !== $name) {
                    return false;
                }

                if ($route->getDomain() !== $domain) {
                    return false;
                }

                if ($wheres !== $route->wheres) {
                    return false;
                }

                if ($defaults !== $route->defaults) {
                    return false;
                }

                if ($route->isFallback !== $isFallback) {
                    return false;
                }

                if ($route->enforcesScopedBindings() !== $enforcesScopedBindings) {
                    return false;
                }

                if ($route->preventsScopedBindings() !== $preventsScopedBindings) {
                    return false;
                }

                if($route->allowsTrashedBindings() !== $withTrashed) {
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
