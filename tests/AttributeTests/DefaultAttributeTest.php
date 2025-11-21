<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DefaultsTestController;

it('can apply defaults on each method of a controller', function () {
        $this->routeRegistrar->registerClass(DefaultsTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                DefaultsTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-get-method/{param?}',
                defaults: ['param' => 'controller-default']
            )->assertRouteRegistered(
                DefaultsTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-post-method/{param?}/{param2?}',
                defaults: ['param' => 'controller-default', 'param2' => 'method-default']
            );
});

it('can apply more than one default on a method', function () {
        $this->routeRegistrar->registerClass(DefaultsTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                DefaultsTestController::class,
                controllerMethod: 'myDefaultMethod',
                uri: 'my-default-method/{param?}/{param2?}/{param3?}',
                defaults: [
                    'param' => 'controller-default',
                    'param2' => 'method-default-first',
                    'param3' => 'method-default-second',
                ]
            );
});

it('can override controller defaults', function () {
        $this->routeRegistrar->registerClass(DefaultsTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                DefaultsTestController::class,
                controllerMethod: 'myOverrideMethod',
                uri: 'my-override-method/{param?}',
                defaults: ['param' => 'method-default']
            );
});