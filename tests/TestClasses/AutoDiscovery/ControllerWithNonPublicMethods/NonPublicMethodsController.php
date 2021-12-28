<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\ControllerWithNonPublicMethods;

class NonPublicMethodsController
{
    public function index()
    {
    }

    protected function willNotBeDiscovered()
    {
    }

    private function anotherOneThatWillNotBeDiscovered()
    {
    }
}
