<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Patch;

class PatchMultipleTestController
{
    #[Patch('my-patch-method')]
    #[Patch('my-other-patch-method')]
    public function myPatchMethod() {}
}
