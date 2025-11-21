<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\BindingScoping1TestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\BindingScoping2TestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\BindingScoping3TestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\BindingScoping4TestController;

it('can enable binding scoping on each method of a controller', function () {
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
});

it('can disable binding scoping on individual methods of a controller', function () {
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
});

it('can enable binding scoping on individual methods of a controller', function () {
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
});

it('respects default scope bindings setting from config', function () {
        config()->set('route-attributes.scope-bindings', true);

        $this->routeRegistrar->registerClass(BindingScoping4TestController::class);

        $this
            ->assertRegisteredRoutesCount(2)
            ->assertRouteRegistered(
                BindingScoping4TestController::class,
                controllerMethod: 'index',
                uri: 'default-scoping',
                enforcesScopedBindings: true,
                preventsScopedBindings: false
            )
            ->assertRouteRegistered(
                BindingScoping4TestController::class,
                controllerMethod: 'store',
                httpMethods: 'post',
                uri: 'explicitly-disabled-scoping',
                enforcesScopedBindings: false,
                preventsScopedBindings: true
            );
});