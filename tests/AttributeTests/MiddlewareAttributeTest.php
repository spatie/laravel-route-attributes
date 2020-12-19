<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\middlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\OtherTestmiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\Testmiddleware;

class middlewareAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_middleware_on_each_method_of_a_controller()
    {
        $this->routeRegistrar->registerClass(middlewareTestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                middlewareTestController::class,
                controllerMethod: 'singlemiddleware',
                uri: 'single-middleware',
                middleware: [Testmiddleware::class],
            )
            ->assertRouteRegistered(
                middlewareTestController::class,
                controllerMethod: 'multiplemiddleware',
                uri: 'multiple-middleware',
                middleware: [Testmiddleware::class, OtherTestmiddleware::class],
            );
    }
}
