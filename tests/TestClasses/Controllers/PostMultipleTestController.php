<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Post;

class PostMultipleTestController
{
    #[Post('my-post-method')]
    #[Post('my-other-post-method')]
    public function myPostMethod() {}
}
