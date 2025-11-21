<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Patch;

class PatchTestController
{
    #[Patch('my-patch-method')]
    public function myPatchMethod() {}
}
