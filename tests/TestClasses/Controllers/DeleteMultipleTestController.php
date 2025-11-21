<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Delete;

class DeleteMultipleTestController
{
    #[Delete('my-delete-method')]
    #[Delete('my-other-delete-method')]
    public function myDeleteMethod() {}
}
