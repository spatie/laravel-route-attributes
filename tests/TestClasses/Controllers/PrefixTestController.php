<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('my-prefix')]
class PrefixTestController
{
    #[Get('/')]
    public function myRootGetMethod() {}

    #[Get('my-get-method')]
    public function myGetMethod() {}

    #[Post('my-post-method')]
    public function myPostMethod() {}
}
