<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource;

use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Resource;

#[Resource('posts', parameters: ['posts' => 'draft'])]
class ResourceTestParametersController
{
    public function index() {}

    public function create() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
