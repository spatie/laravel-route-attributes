<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\DomainFromConfig;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

#[DomainFromConfig('domains.test')]
class DomainFromConfigTestController
{
    #[Get('my-get-method')]
    public function myGetMethod() {}

    #[Post('my-post-method')]
    public function myPostMethod() {}
}
