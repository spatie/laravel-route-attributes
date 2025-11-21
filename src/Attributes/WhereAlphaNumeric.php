<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class WhereAlphaNumeric extends Where
{
    public function __construct(string $param)
    {
        $this->param = $param;
        $this->constraint = '[a-zA-Z0-9]+';
    }
}
