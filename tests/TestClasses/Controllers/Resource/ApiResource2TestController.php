<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers\Resource;

use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\ApiResource;

#[ApiResource('posts')]
class ApiResource2TestController
{
    public function index()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
