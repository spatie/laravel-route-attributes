<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Patch;

class PatchControllerTest
{
    #[Patch('my-patch-method')]
    public function myPatchMethod()
    {
    }
}
