<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Route;

class PostRouteTestController
{
    #[Route('post', 'my-post-method')]
    public function myPostMethod()
    {
    }
}
