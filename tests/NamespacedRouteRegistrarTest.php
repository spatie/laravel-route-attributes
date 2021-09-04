<?php

declare(strict_types=1);

namespace Spatie\RouteAttributes\Tests;

use MyOrg\MyPackage\NamespacedTestController;

class NamespacedRouteRegistrarTest extends TestCase
{
    /** @test */
    public function the_registrar_can_register_a_single_file()
    {
        $this
            ->routeRegistrar
            ->registerFile($this->getTestPath('NamespacedClasses/NamespacedTestController.php'));

        $this->assertRegisteredRoutesCount(1);

        $this->assertRouteRegistered(
            NamespacedTestController::class,
            'myNamespacedMethod',
            'GET',
            'my-namespaced-method',
        );
    }
}
