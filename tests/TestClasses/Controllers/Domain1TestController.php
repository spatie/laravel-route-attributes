<?php

declare(strict_types=1);

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\DomainFromConfig;
use Spatie\RouteAttributes\Attributes\Get;

#[DomainFromConfig('domains.test')]
class Domain1TestController
{
    #[Get('my-get-method')]
    public function myGetMethod() {}
}
