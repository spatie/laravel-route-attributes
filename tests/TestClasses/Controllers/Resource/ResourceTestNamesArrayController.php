<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource;

use Spatie\RouteAttributes\Attributes\Resource;

#[Resource('posts', only: ['index', 'show'], names: ['index' => 'posts.list', 'show' => 'posts.view'])]
class ResourceTestNamesArrayController
{
    public function index() {}

    public function show($id) {}
}
