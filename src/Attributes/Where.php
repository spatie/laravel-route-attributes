<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Where implements WhereAttribute
{
    public function __construct(
        public string $param,
        public string $constraint,
    ) {}
}
