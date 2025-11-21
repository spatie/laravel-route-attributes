<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Defaults;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

#[Defaults('param', 'controller-default')]
class DefaultsTestController
{
    #[Get('my-get-method/{param?}')]
    public function myGetMethod() {}

    #[Post('my-post-method/{param?}/{param2?}')]
    #[Defaults('param2', 'method-default')]
    public function myPostMethod() {}

    #[Get('my-default-method/{param?}/{param2?}/{param3?}')]
    #[Defaults('param2', 'method-default-first')]
    #[Defaults('param3', 'method-default-second')]
    public function myDefaultMethod() {}

    #[Get('my-override-method/{param?}')]
    #[Defaults('param', 'method-default')]
    public function myOverrideMethod() {}
}
