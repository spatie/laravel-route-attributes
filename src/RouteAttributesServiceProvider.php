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

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/laravel-route-attributes'),
            ], 'views');

            $migrationFileName = 'create_laravel_route_attributes_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                RouteAttributesCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-route-attributes');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-route-attributes.php', 'laravel-route-attributes');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
