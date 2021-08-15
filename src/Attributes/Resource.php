<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Resource implements RouteAttribute
{
    public function __construct(
        public string $resource,
        public array | string | null $except = null,
        public array | string | null $only = null,
    ) {
    }
}
