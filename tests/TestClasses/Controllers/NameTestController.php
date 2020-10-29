<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Name;
use Spatie\RouteAttributes\Attributes\Post;

#[Name('my-name.')]
class NameTestController
{
    #[Get('my-get-method', name: 'my-get-method')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-method')]
    public function myPostMethod()
    {
    }
}
