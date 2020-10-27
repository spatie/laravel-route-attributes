<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute]
class Route implements RouteAttribute
{
    public function __construct(
        public string $method,
        public string $url
    ) {}
}
