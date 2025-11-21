<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class ScopeBindings implements RouteAttribute
{
    public function __construct(
        public bool $scopeBindings = true
    ) {}
}
