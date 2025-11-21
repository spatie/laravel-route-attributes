<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Where;
use Spatie\RouteAttributes\Attributes\WhereAlpha;
use Spatie\RouteAttributes\Attributes\WhereAlphaNumeric;
use Spatie\RouteAttributes\Attributes\WhereIn;
use Spatie\RouteAttributes\Attributes\WhereNumber;
use Spatie\RouteAttributes\Attributes\WhereUlid;
use Spatie\RouteAttributes\Attributes\WhereUuid;

#[Where('param', '[0-9]+')]
class WhereTestController
{
    #[Get('my-get-method/{param}')]
    public function myGetMethod() {}

    #[Post('my-post-method/{param}/{param2}')]
    #[Where('param2', '[a-zA-Z]+')]
    public function myPostMethod() {}

    #[Get('my-where-method/{param}/{param2}/{param3}')]
    #[Where('param2', '[a-zA-Z]+')]
    #[Where('param3', 'test')]
    public function myWhereMethod() {}

    #[Get('my-shorthands')]
    #[WhereAlpha('alpha')]
    #[WhereAlphaNumeric('alpha-numeric')]
    #[WhereIn('in', ['value1', 'value2'])]
    #[WhereNumber('number')]
    #[WhereUlid('ulid')]
    #[WhereUuid('uuid')]
    public function myShorthands() {}
}
