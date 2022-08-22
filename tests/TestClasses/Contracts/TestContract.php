<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Contracts;

use Spatie\RouteAttributes\Attributes\Any;

interface TestContract
{
    #[Any('my-any-method')]
    public function myAnyMethod();
}
