<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\NestedController;

class ParentController
{
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
