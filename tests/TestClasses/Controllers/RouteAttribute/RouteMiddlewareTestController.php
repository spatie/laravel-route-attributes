<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\Testmiddleware;

class RoutemiddlewareTestController
{
    #[Route('get', 'my-method', middleware: Testmiddleware::class)]
    public function myMethod()
    {
    }
}
