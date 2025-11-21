<?php

declare(strict_types=1);

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\ScopeBindings;

final class BindingScoping4TestController
{
    #[Get('default-scoping')]
    public function index() {}

    #[ScopeBindings(false)]
    #[Post('explicitly-disabled-scoping')]
    public function store() {}
}
