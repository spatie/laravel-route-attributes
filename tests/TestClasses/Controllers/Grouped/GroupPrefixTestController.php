<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('my-prefix')]
class GroupPrefixTestController
{
    #[Get('my-prefix-get-method')]
    public function myGetMethod()
    {
    }

    #[Post('my-prefix-post-method')]
    public function myPostMethod()
    {
    }
}
