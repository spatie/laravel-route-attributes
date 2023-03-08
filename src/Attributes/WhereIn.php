<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class WhereIn extends Where
{
    public function __construct(string $param, array $constraint)
    {
        $this->param = $param;
        $this->constraint = implode('|', $constraint);
    }
}
