<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteAttributes\Attributes\Route;

class RouteMultiVerbTestController
{
    #[Route(['get', 'post', 'delete'], 'my-multi-verb-method')]
    public function myMultiVerbMethod() {}
}
