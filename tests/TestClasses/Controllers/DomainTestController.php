<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Domain;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

#[Domain('my-subdomain.localhost')]
class DomainTestController
{
    #[Get('my-get-method')]
    public function myGetMethod() {}

    #[Post('my-post-method')]
    public function myPostMethod() {}
}
