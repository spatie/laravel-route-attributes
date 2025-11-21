<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Group;
use Spatie\RouteAttributes\Attributes\Post;

#[Group(domain: 'my-subdomain.localhost', prefix: 'my-prefix')]
#[Group(domain: 'my-second-subdomain.localhost', prefix: 'my-second-prefix')]
class GroupTestController
{
    #[Get('my-get-method')]
    public function myGetMethod() {}

    #[Post('my-post-method')]
    public function myPostMethod() {}
}
