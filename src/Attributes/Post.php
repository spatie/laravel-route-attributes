<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Post extends Route
{
    public function __construct(
        public string $method,
        public ?string $name = null,
        array|string $middleware = [],
    ) {
        parent::__construct(...['post', ...func_get_args()]);
    }
}
