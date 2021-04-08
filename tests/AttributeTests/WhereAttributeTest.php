<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\WhereTestController;

class WhereAttributeTest extends TestCase
{
    /** @test */
    public function it_can_apply_where_on_each_method_of_a_controller()
    {
        $this->routeRegistrar->registerClass(WhereTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                WhereTestController::class,
                controllerMethod: 'myGetMethod',
                uri: 'my-get-method/{param}',
                wheres: ['param' => '[0-9]+']
            )
            ->assertRouteRegistered(
                WhereTestController::class,
                controllerMethod: 'myPostMethod',
                httpMethods: 'post',
                uri: 'my-post-method/{param}/{param2}',
                wheres: ['param' => '[0-9]+', 'param2' => '[a-zA-Z]+']
            );
    }

    /** @test */
    public function it_can_apply_where_on_a_method()
    {
        $this->routeRegistrar->registerClass(WhereTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                WhereTestController::class,
                controllerMethod: 'myWhereMethod',
                uri: 'my-where-method/{param}/{param2}/{param3}',
                wheres: ['param' => '[0-9]+', 'param2' => '[a-zA-Z]+', 'param3' => 'test']
            );
    }

    /** @test */
    public function it_can_apply_shorthand_where()
    {
        $this->routeRegistrar->registerClass(WhereTestController::class);

        $this
            ->assertRegisteredRoutesCount(4)
            ->assertRouteRegistered(
                WhereTestController::class,
                controllerMethod: 'myShorthands',
                uri: 'my-shorthands',
                wheres: [
                    'param' => '[0-9]+',
                    'alpha' => '[a-zA-Z]+',
                    'alpha-numeric' => '[a-zA-Z0-9]+',
                    'number' => '[0-9]+',
                    'uuid' => '[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}',
                ]
            );
    }
}
