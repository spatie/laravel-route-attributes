<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute;

use Spatie\RouteAttributes\Attributes\Route;

class RoutePostTestController
{
    #[Route('post', 'my-post-method')]
    public function myPostMethod() {}
}
