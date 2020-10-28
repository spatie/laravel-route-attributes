<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Post;

class PostControllerTest
{
    #[Post('my-post-method')]
    public function myPostMethod()
    {
    }
}
