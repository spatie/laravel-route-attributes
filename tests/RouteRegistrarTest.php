<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestFirstController;

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
}
