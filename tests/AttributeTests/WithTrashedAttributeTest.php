<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\WithTrashedTestController;

it('can apply withTrashed on a controller', function () {
    $this->routeRegistrar->registerClass(WithTrashedTestController::class);

    $this
        ->expectRegisteredRoutesCount(3)
        ->expectRouteRegistered(
            WithTrashedTestController::class,
            controllerMethod: 'withTrashedRoute',
            httpMethods: 'get',
            uri: 'with-trashed-test-method/{param}',
            withTrashed: true,
        )
        ->expectRouteRegistered(
            WithTrashedTestController::class,
            controllerMethod: 'withoutTrashedRoute',
            httpMethods: 'get',
            uri: 'with-trashed-test-method-2/{param}',
            withTrashed: false,
        )
        // registered through
        ->expectRouteRegistered(
            WithTrashedTestController::class,
            controllerMethod: 'noWithTrashedAttributeRoute',
            httpMethods: 'get',
            uri: 'with-trashed-test-method-3/{param}',
            withTrashed: true,
        );
});
