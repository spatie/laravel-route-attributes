<?php

namespace Spatie\RouteAttributes;

use Illuminate\Support\ServiceProvider;

class RouteAttributesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/route-attributes.php' => config_path('route-attributes.php'),
            ], 'config');
        }

        $this->registerRoutes();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/route-attributes.php', 'route-attributes');
    }

    protected function registerRoutes(): void
    {
        if (!$this->shouldRegisterRoutes()) {
            return;
        }

        $routeRegistrar = (new RouteRegistrar(app()->router))
            ->useMiddleware(config('route-attributes.middleware') ?? []);


        collect($this->getRouteDirectories())->each(function (string $directory, string|int $namespace) use (
            $routeRegistrar
        ) {
            if (!is_string($namespace)) {
                $routeRegistrar
                    ->hasNamespaceKey(false)
                    ->useRootNamespace(app()->getNamespace());
            } else {
                $routeRegistrar
                    ->hasNamespaceKey(true)
                    ->useRootNamespace($namespace)
                    ->useBasePath($directory);
            }

            $routeRegistrar->registerDirectory($directory);
        });
    }

    private function shouldRegisterRoutes(): bool
    {
        if (! config('route-attributes.enabled')) {
            return false;
        }

        if ($this->app->routesAreCached()) {
            return false;
        }

        return true;
    }

    private function getRouteDirectories(): array
    {
        $testClassDirectory = __DIR__ . '/../tests/TestClasses';

        return app()->runningUnitTests() && file_exists($testClassDirectory) ? (array)$testClassDirectory : config('route-attributes.directories');
    }
}
