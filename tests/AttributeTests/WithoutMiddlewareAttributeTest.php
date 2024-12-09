<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\WithoutMiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Middleware\SkippedMiddleware;

class WithoutMiddlewareAttributeTest extends TestCase
{
    /** @test */
    public function it_can_skip_middleware_added_to_class()
    {
        $this->routeRegistrar->registerClass(WithoutMiddlewareTestController::class);


        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(
                WithoutMiddlewareTestController::class,
                controllerMethod: 'withoutMiddleware',
                uri: 'without-middleware',
                withoutMiddleware: [SkippedMiddleware::class],
            );
    }
}
