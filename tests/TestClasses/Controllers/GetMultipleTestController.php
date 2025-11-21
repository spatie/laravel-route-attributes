<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;

class GetMultipleTestController
{
    #[Get('my-get-method')]
    #[Get('my-other-get-method')]
    public function myGetMethod() {}
}
