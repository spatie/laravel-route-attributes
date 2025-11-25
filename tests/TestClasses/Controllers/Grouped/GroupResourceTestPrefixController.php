<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped;

use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Resource;

#[Prefix('/api/v1/my-prefix/etc')]
#[Resource('posts', only: ['index', 'show'], names: 'prefixed_posts')]
class GroupResourceTestPrefixController
{
    public function index() {}

    public function show($id) {}
}
