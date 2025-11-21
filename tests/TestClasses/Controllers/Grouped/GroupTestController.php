<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

class GroupTestController
{
    #[Get('my-get-method', middleware: ['test'])]
    public function myGetMethod() {}

    #[Post('my-post-method')]
    public function myPostMethod() {}
}
