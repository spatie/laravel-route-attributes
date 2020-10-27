<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Prefix
{
    public function __construct(
        public $prefix
    ) {}
}
