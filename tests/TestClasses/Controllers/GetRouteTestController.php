<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Route;

class GetRouteTestController
{
    #[Route('get', 'my-get-method-route')]
    public function myGetMethod()
    {
    }
}
