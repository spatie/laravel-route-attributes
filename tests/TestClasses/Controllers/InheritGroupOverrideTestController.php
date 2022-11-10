<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;
use Spatie\RouteAttributes\Attributes\Group;

#[Group(domain: 'new-subdomain.localhost', prefix: 'new-prefix')]
class InheritGroupOverrideTestController extends GroupTestController
{
}
