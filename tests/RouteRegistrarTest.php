<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestFirstController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestSecondController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\SubDirectory\RegistrarTestControllerInSubDirectory;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\AnotherTestMiddleware;

uses(TestCase::class);

test('the registrar can register a single file', function () {
    $this
        ->routeRegistrar
        ->registerFile($this->getTestPath('TestClasses/Controllers/RouteRegistrar/RegistrarTestFirstController.php'));

    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        RegistrarTestFirstController::class,
        uri: 'first-method',
    );
});

test('the registrar can apply config middlewares to all routes', function () {
    $this
        ->routeRegistrar
        ->registerFile($this->getTestPath('TestClasses/Controllers/RouteRegistrar/RegistrarTestFirstController.php'));

    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        RegistrarTestFirstController::class,
        uri: 'first-method',
        middleware: [AnotherTestMiddleware::class]
    );
});

test('the registrar can register a whole directory', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Controllers/RouteRegistrar'));

    $this->assertRegisteredRoutesCount(3);

    $this->assertRouteRegistered(
        RegistrarTestFirstController::class,
        uri: 'first-method',
    );

    $this->assertRouteRegistered(
        RegistrarTestSecondController::class,
        uri: 'second-method',
    );

    $this->assertRouteRegistered(
        RegistrarTestControllerInSubDirectory::class,
        uri: 'in-sub-directory',
    );
});
