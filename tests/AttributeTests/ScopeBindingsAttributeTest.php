<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\BindingScoping1TestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\BindingScoping2TestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\BindingScoping3TestController;

class ScopeBindingsAttributeTest extends TestCase
{
    /** @test */
    public function it_can_enable_binding_scoping_on_each_method_of_a_controller()
    {
        $this->routeRegistrar->registerClass(BindingScoping2TestController::class);

        $this
            ->assertRegisteredRoutesCount(3)
            ->assertRouteRegistered(
                BindingScoping2TestController::class,
                controllerMethod: 'explicitlyEnabledScopedBinding',
                uri: 'explicitly-enabled/{scoped}/{binding}',
                enforcesScopedBindings: true,
                preventsScopedBindings: false
            )
            ->assertRouteRegistered(
                BindingScoping2TestController::class,
                controllerMethod: 'explicitlyDisabledScopedBinding',
                uri: 'explicitly-disabled/{scoped}/{binding}',
                enforcesScopedBindings: false,
                preventsScopedBindings: true
            )
            ->assertRouteRegistered(
                BindingScoping2TestController::class,
                controllerMethod: 'implicitlyDisabledScopedBinding',
                uri: 'implicitly-disabled/{scoped}/{binding}',
                enforcesScopedBindings: false,
                preventsScopedBindings: false
            );
    }

    /** @test */
    public function it_can_disable_binding_scoping_on_individual_methods_of_a_controller()
    {
        $this->routeRegistrar->registerClass(BindingScoping1TestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                BindingScoping1TestController::class,
                controllerMethod: 'implicitlyEnabledScopedBinding',
                uri: 'implicit/{scoped}/{binding}',
                enforcesScopedBindings: true,
                preventsScopedBindings: false
            )
            ->assertRouteRegistered(
                BindingScoping1TestController::class,
                controllerMethod: 'explicitlyDisabledScopedBinding',
                uri: 'explicitly-disabled/{scoped}/{binding}',
                enforcesScopedBindings: false,
                preventsScopedBindings: true
            );
    }

    /** @test */
    public function it_can_enable_binding_scoping_on_individual_methods_of_a_controller()
    {
        $this->routeRegistrar->registerClass(BindingScoping3TestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                BindingScoping3TestController::class,
                controllerMethod: 'explicitlyDisabledByClassScopedBinding',
                uri: 'explicitly-disabled-by-class/{scoped}/{binding}',
                enforcesScopedBindings: false,
                preventsScopedBindings: true
            )
            ->assertRouteRegistered(
                BindingScoping3TestController::class,
                controllerMethod: 'explicitlyEnabledOverridingClassScopedBinding',
                uri: 'explicitly-enabled-overriding-class/{scoped}/{binding}',
                enforcesScopedBindings: true,
                preventsScopedBindings: false
            );
    }
}
