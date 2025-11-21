<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class DomainFromConfig implements RouteAttribute
{
    public function __construct(
        public string $domain
    ) {}
}
