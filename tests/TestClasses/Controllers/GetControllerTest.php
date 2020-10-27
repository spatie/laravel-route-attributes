<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;

class GetControllerTest
{
    #[Get('my-get-method')]
    public function myGetMethod()
    {
    }
}
