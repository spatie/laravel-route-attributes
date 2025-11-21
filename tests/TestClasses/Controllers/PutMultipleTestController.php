<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Put;

class PutMultipleTestController
{
    #[Put('my-put-method')]
    #[Put('my-other-put-method')]
    public function myPutMethod() {}
}
