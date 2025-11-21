<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteRegistrar\SubDirectory;

use Spatie\RouteAttributes\Attributes\Get;

class RegistrarTestControllerInSubDirectory
{
    #[Get('in-sub-directory')]
    public function myMethod() {}
}
