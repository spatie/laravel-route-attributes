<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class Group implements RouteAttribute
{
    public function __construct(
        public ?string $prefix = null,
        public ?string $domain = null,
        public ?string $as = null,
        public ?array $where = [],
    ) {}
}
