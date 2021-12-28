<?php

use Illuminate\Routing\ViewController;
use Spatie\RouteAttributes\RouteDiscovery\Discover;
use Spatie\RouteAttributes\Tests\TestCase;

uses(TestCase::class);

it('can discover views in a directory', function () {
    Discover::views()->in($this->getTestPath('TestClasses/resources/views'));

    $this->assertRegisteredRoutesCount(6);

    collect([
        '/',
        'home',
        'long-name',
        'contact',
        'nested',
        'nested/another',
    ])->each(function (string $uri) {
        $this->assertRouteRegistered(
            ViewController::class,
            controllerMethod: '\\' . ViewController::class,
            uri: $uri,
        );
    });
});
