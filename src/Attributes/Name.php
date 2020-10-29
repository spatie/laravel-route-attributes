<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Name implements RouteAttribute
{
    public function __construct(
        public $name
    ) {}
}
