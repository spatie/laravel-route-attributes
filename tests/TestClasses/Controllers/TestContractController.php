<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Any;
use Spatie\RouteAttributes\Tests\TestClasses\Contracts\TestContract;

class TestContractController implements TestContract
{
    public function myAnyMethod()
    {
    }
}
