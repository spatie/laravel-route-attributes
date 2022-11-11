<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\DefaultsTestController;

class DefaultAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_defaults_on_each_method_of_a_controller()
    {
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
    }

    /** @test */
    public function it_can_apply_more_than_one_defaults_on_a_method()
    {
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
                    'param3' => 'method-default-second'
                ]
            );
    }

    /** @test */
    public function it_can_override_controller_defaults()
    {
        $this->routeRegistrar->registerClass(DefaultsTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                DefaultsTestController::class,
                controllerMethod: 'myOverrideMethod',
                uri: 'my-override-method/{param?}',
                defaults: ['param' => 'method-default']
            );
    }
}
