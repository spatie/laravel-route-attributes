<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped;

use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\ApiResource;

#[ApiResource('posts')]
class GroupResourceTestController
{
    public function index() {}

    public function store(Request $request) {}

    public function show($id) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
