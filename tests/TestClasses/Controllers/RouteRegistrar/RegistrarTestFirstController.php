<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar;

use Spatie\RouteAttributes\Attributes\Get;

class RegistrarTestFirstController
{
    #[Get('first-method')]
    public function myMethod() {}
}
