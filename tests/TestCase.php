<?php

namespace Spatie\RouteAttributes\Tests;

use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Arr;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\RouteAttributes\RouteRegistrar;

class TestCase extends Orchestra
{
    protected RouteRegistrar $routeRegistrar;

    protected function defineEnvironment($app)
    {
        // Disable automatic filesystem serving routes that TestBench adds in Laravel 12
        $app['config']->set('filesystems.disks.local.serve', false);

        return parent::defineEnvironment($app);
    }

    public function getTestPath(?string $directory = null): string
    {
        return __DIR__.($directory ? DIRECTORY_SEPARATOR.$directory : '');
    }

    public function expectRegisteredRoutesCount(int $expectedNumber): self
    {
        $actualNumber = $this->getRouteCollection()->count();

        expect($actualNumber)->toBe($expectedNumber);

        return $this;
    }

    public function expectRouteRegistered(
        string $controller,
        string $controllerMethod = 'myMethod',
        string|array $httpMethods = ['get'],
        string $uri = 'my-method',
        string|array $middleware = [],
        string|array $withoutMiddleware = [],
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

        if (! is_array($withoutMiddleware)) {
            $withoutMiddleware = Arr::wrap($withoutMiddleware);
        }

        $routeRegistered = collect($this->getRouteCollection()->getRoutes())
            ->contains(function (Route $route) use ($name, $middleware, $withoutMiddleware, $controllerMethod, $controller, $uri, $httpMethods, $domain, $wheres, $isFallback, $enforcesScopedBindings, $preventsScopedBindings, $defaults, $withTrashed) {
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

                if (array_diff($withoutMiddleware, $route->excludedMiddleware())) {
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

                if ($route->allowsTrashedBindings() !== $withTrashed) {
                    return false;
                }

                return true;
            });

        expect($routeRegistered)->toBeTrue('The expected route was not registered');

        return $this;
    }

    protected function getRouteCollection(): RouteCollection
    {
        return app()->router->getRoutes();
    }
}
