<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteAttributes\Attributes\Route;

class InvokableRouteGetTestController
{
    #[Route('get', 'my-invokable-route')]
    public function __invoke() {}
}
