<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;

class GetTestController
{
    #[Get('my-get-method')]
    public function myGetMethod() {}
}
