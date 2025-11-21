<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\WhereTestController;

it('can apply where on each method of a controller', function () {
    $this->routeRegistrar->registerClass(WhereTestController::class);

    $this
        ->expectRegisteredRoutesCount(4)
        ->expectRouteRegistered(
            WhereTestController::class,
            controllerMethod: 'myGetMethod',
            uri: 'my-get-method/{param}',
            wheres: ['param' => '[0-9]+']
        )
        ->expectRouteRegistered(
            WhereTestController::class,
            controllerMethod: 'myPostMethod',
            httpMethods: 'post',
            uri: 'my-post-method/{param}/{param2}',
            wheres: ['param' => '[0-9]+', 'param2' => '[a-zA-Z]+']
        );
});

it('can apply where on a method', function () {
    $this->routeRegistrar->registerClass(WhereTestController::class);

    $this
        ->expectRegisteredRoutesCount(4)
        ->expectRouteRegistered(
            WhereTestController::class,
            controllerMethod: 'myWhereMethod',
            uri: 'my-where-method/{param}/{param2}/{param3}',
            wheres: ['param' => '[0-9]+', 'param2' => '[a-zA-Z]+', 'param3' => 'test']
        );
});

it('can apply shorthand where', function () {
    $this->routeRegistrar->registerClass(WhereTestController::class);

    $this
        ->expectRegisteredRoutesCount(4)
        ->expectRouteRegistered(
            WhereTestController::class,
            controllerMethod: 'myShorthands',
            uri: 'my-shorthands',
            wheres: [
                'param' => '[0-9]+',
                'alpha' => '[a-zA-Z]+',
                'alpha-numeric' => '[a-zA-Z0-9]+',
                'in' => 'value1|value2',
                'number' => '[0-9]+',
                'ulid' => '[0-7][0-9A-HJKMNP-TV-Z]{25}',
                'uuid' => '[\da-fA-F]{8}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{4}-[\da-fA-F]{12}',
            ]
        );
});
