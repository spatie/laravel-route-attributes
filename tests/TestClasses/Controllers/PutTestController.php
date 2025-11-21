<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Put;

class PutTestController
{
    #[Put('my-put-method')]
    public function myPutMethod() {}
}
