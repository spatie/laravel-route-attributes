<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Any;

class AnyTestController
{
    #[Any('my-any-method')]
    public function myAnyMethod() {}
}
