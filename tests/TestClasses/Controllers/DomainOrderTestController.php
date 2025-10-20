<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Group;
use Spatie\RouteAttributes\Attributes\Post;

#[Group(domain: 'domain.localhost', prefix: 'my-prefix')]
#[Group(prefix: 'my-second-prefix')]
class DomainOrderTestController
{
    #[Get('my-get-method')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-method')]
    public function myPostMethod()
    {
    }
}
