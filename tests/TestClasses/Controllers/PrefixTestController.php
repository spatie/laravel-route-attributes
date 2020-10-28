<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('my-prefix')]
class PrefixTestController
{
    #[Get('first-method')]
    public function firstMethod()
    {
    }

    #[Get('second-method')]
    public function secondMethod()
    {
    }
}
