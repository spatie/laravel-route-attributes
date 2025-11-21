<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteAttributes\Attributes\Domain;
use Spatie\RouteAttributes\Attributes\Resource;

#[Domain('my-subdomain.localhost')]
#[Resource('posts', only: ['index', 'show'])]
class ResourceTestDomainController
{
    public function index() {}

    public function show($id) {}
}
