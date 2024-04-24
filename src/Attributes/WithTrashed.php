<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class WithTrashed implements RouteAttribute
{
    public bool $withTrashed;

    public function __construct(bool $withTrashed = true)
    {
        $this->withTrashed = $withTrashed;
    }
}
