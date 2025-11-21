<?php

use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\AnotherTestMiddleware;

uses(TestCase::class)
    ->beforeEach(function () {
        $router = app()->router;

        $this->routeRegistrar = (new RouteRegistrar($router))
            ->useBasePath($this->getTestPath())
            ->useMiddleware([AnotherTestMiddleware::class])
            ->useRootNamespace('Spatie\RouteAttributes\Tests\\');
    })
    ->in(__DIR__);
