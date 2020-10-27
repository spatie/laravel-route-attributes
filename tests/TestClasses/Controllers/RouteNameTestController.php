<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Route;

class RouteNameTestController
{
    #[Route('get', 'my-method', name: 'test-name')]
    public function myMethod()
    {
    }
}
