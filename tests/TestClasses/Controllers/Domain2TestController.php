<?php

declare(strict_types=1);

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\DomainFromConfig;
use Spatie\RouteAttributes\Attributes\Get;

#[DomainFromConfig('domains.test2')]
class Domain2TestController
{
    #[Get('my-get-method')]
    public function myGetMethod() {}
}
