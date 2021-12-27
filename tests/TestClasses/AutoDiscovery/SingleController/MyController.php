<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\SingleController;

class MyController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
