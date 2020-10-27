<?php

namespace Spatie\RouteAttributes;

use Illuminate\Support\ServiceProvider;
use Spatie\RouteAttributes\Commands\RouteAttributesCommand;

class RouteAttributesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-route-attributes.php' => config_path('laravel-route-attributes.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-route-attributes.php', 'laravel-route-attributes');
    }
}
