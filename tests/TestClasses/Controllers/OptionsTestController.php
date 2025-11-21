<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Options;

class OptionsTestController
{
    #[Options('my-options-method')]
    public function myOptionsMethod() {}
}
