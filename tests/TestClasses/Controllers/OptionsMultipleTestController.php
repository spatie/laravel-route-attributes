<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Options;

class OptionsMultipleTestController
{
    #[Options('my-options-method')]
    #[Options('my-other-options-method')]
    public function myOptionsMethod() {}
}
