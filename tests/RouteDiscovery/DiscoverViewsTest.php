<?php

use Illuminate\Routing\ViewController;
use Spatie\RouteAttributes\RouteDiscovery\Discover;

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
