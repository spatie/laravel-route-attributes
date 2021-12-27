<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\AutoDiscovery\RouteName;

use Spatie\RouteAttributes\Attributes\Route;

class CustomRouteNameController
{
    #[Route(name:'this-is-a-custom-name')]
    public function index()
    {
        return $this::class . '@' . __METHOD__;
    }
}
