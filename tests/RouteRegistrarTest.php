<?php

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestFirstController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\RegistrarTestSecondController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\SubDirectory\RegistrarTestControllerInSubDirectory;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\AnotherTestMiddleware;
use ThirdParty\Http\Controllers\ThirdPartyController;

it('can register a single file', function () {
    $this
        ->routeRegistrar
        ->registerFile($this->getTestPath('TestClasses/Controllers/RouteRegistrar/RegistrarTestFirstController.php'));

    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        RegistrarTestFirstController::class,
        uri: 'first-method',
    );
});

it('can apply config middlewares to all routes', function () {
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

it('can register a whole directory', function () {
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

it('can register a directory with defined namespace', function () {
    require_once(__DIR__ . '/ThirdPartyTestClasses/Controllers/ThirdPartyController.php');
    $this->routeRegistrar
        ->useBasePath($this->getTestPath('ThirdPartyTestClasses' . DIRECTORY_SEPARATOR . 'Controllers'))
        ->useRootNamespace('ThirdParty\Http\Controllers\\')
        ->registerDirectory($this->getTestPath('ThirdPartyTestClasses' . DIRECTORY_SEPARATOR . 'Controllers'));

    $this->assertRegisteredRoutesCount(1);
    $this->assertRouteRegistered(
        ThirdPartyController::class,
        uri: 'third-party',
        controllerMethod: 'thirdPartyGetMethod',
    );
});

it('can register a directory with filename pattern', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Controllers/RouteRegistrar'), ['*FirstController.php']);

    $this->assertRegisteredRoutesCount(1);

    $this->assertRouteRegistered(
        RegistrarTestFirstController::class,
        uri: 'first-method',
    );
});

it('can register a directory with filename not pattern', function () {
    $this
        ->routeRegistrar
        ->registerDirectory($this->getTestPath('TestClasses/Controllers/RouteRegistrar'), [], ['*FirstController.php']);

    $this->assertRegisteredRoutesCount(2);
});
