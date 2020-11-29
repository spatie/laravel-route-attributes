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
        if (! config('route-attributes.enabled')) {
            return;
        }

        $routeRegistrar = (new RouteRegistrar(app()->router))
            ->useRootNamespace('App\\');

        collect(config('route-attributes.directories'))->each(fn (string $directory) => $routeRegistrar->registerDirectory($directory));
    }
}
