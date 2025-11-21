<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Fallback;
use Spatie\RouteAttributes\Attributes\Get;

class FallbackTestController
{
    #[Get('my-fallback-method')]
    #[Fallback]
    public function myFallbackMethod() {}
}
