<?php

namespace Spatie\RouteAttributes\Tests\TestClasses;

use Spatie\RouteAttributes\Attributes\Route;

class PostRouteTestController
{
    #[Route('post', 'my-post-method-route')]
    public function myPostMethod()
    {

    }
}
