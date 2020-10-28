<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Delete;

class DeleteControllerTest
{
    #[Delete('my-delete-method')]
    public function myDeleteMethod()
    {
    }
}
