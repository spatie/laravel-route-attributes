<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;
use Illuminate\Support\Arr;

#[Attribute(Attribute::TARGET_CLASS)]
class Middleware implements RouteAttribute
{
    public array $middleware = [];

    public function __construct(string|array $middleware = [])
    {
        $this->middleware = Arr::wrap($middleware);
    }
}
