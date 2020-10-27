<?php

namespace Spatie\RouteAttributes\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;
use Orchestra\Testbench\TestCase as Orchestra;
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

    public function assertRegisteredRoutesCount(int $expectedNumber): void
    {
        $actualNumber = $this->getRouteCollection()->count();

        $this->assertEquals($expectedNumber, $actualNumber);
    }

    public function assertRouteRegistered(string $httpMethod, string $uri, string $controllerClass, string $controllerMethod)
    {
        $routeRegistered = collect($this->getRouteCollection()->getRoutes())
            ->contains(function(Route $route) use ($controllerMethod, $controllerClass, $uri, $httpMethod) {

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

                return true;
        });

        $this->assertTrue($routeRegistered, 'The expected route was not registered');
    }

    protected function getRouteCollection(): RouteCollection
    {
        return app()->router->getRoutes();
    }
}
