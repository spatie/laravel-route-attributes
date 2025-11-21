<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Delete;

class DeleteTestController
{
    #[Delete('my-delete-method')]
    public function myDeleteMethod() {}
}
