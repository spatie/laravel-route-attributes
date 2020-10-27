<?php

namespace Spatie\RouteAttributes\Tests;

use Arr;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Orchestra\Testbench\TestCase as Orchestra;
use PHPUnit\Framework\Assert;
use Spatie\RouteAttributes\RouteAttributesServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\RouteAttributes\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
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
        string $httpMethod,
        string $uri,
        string $controllerClass,
        string $controllerMethod,
        string|array $middleware = [],
        ?string $name = null,
    ): self {
        if (! is_array($middleware)) {
            $middleware = Arr::wrap($middleware);
        }

        $routeRegistered = collect($this->getRouteCollection()->getRoutes())
            ->contains(function (Route $route) use ($name, $middleware, $controllerMethod, $controllerClass, $uri, $httpMethod) {
                if (! in_array(strtoupper($httpMethod), $route->methods)) {
                    return false;
                }

                if ($route->uri() !== $uri) {
                    return false;
                }

                if (get_class($route->getController()) !== $controllerClass) {
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
