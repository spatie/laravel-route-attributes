<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestFirstController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestSecondController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\SubDirectory\RegistrarTestControllerInSubDirectory;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\AnotherTestmiddleware;

class RouteRegistrarTest extends TestCase
{
    /** @test */
    public function the_registrar_can_register_a_single_file()
    {
        $this
            ->routeRegistrar
            ->registerFile($this->getTestPath('TestClasses/Controllers/RouteRegistrar/RegistrarTestFirstController.php'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            RegistrarTestFirstController::class,
            uri: 'first-method',
        );
    }

    /** @test */
    public function the_registrar_can_apply_config_middlewares_to_all_routes()
    {
        $this
            ->routeRegistrar
            ->registerFile($this->getTestPath('TestClasses/Controllers/RouteRegistrar/RegistrarTestFirstController.php'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            RegistrarTestFirstController::class,
            uri: 'first-method',middleware: [AnotherTestmiddleware::class]

        );
    }

    /** @test */
    public function the_registrar_can_register_a_whole_directory()
    {
        $this
            ->routeRegistrar
            ->registerDirectory($this->getTestPath('TestClasses/Controllers/RouteRegistrar'));

        $this->assertRegisteredRoutesCount(3);

        $this->assertRouteRegistered(
            RegistrarTestFirstController::class,
            uri: 'first-method',
        );

        $this->assertRouteRegistered(
            RegistrarTestSecondController::class,
            uri: 'second-method',
        );

        $this->assertRouteRegistered(
            RegistrarTestControllerInSubDirectory::class,
            uri: 'in-sub-directory',
        );
    }
}
