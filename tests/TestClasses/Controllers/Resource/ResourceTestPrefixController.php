<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Resource;

#[Prefix('/api/v1/my-prefix/etc')]
#[Resource('posts', only: ['index', 'show'])]
class ResourceTestPrefixController
{
    public function index() {}

    public function show($id) {}
}
