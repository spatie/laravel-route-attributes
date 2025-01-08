<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Prefix implements RouteAttribute
{
    public function __construct(
        public string $prefix
    ) {
    }
}
