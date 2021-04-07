<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Wheres;

#[Wheres(['param' => '[0-9]+'])]
class WheresTestController
{
    #[Get('my-get-method/{param}')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-method/{param}')]
    public function myPostMethod()
    {
    }

    #[Get('my-where-method/{param}/{param2}')]
    #[Wheres(['param2' => '[a-zA-Z]+'])]
    public function myWhereMethod()
    {

    }
}
