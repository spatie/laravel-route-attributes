<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute]
class Post extends Route
{
    public array $middleware;

    public function __construct(
        public string $method,
        public ?string $name = null,
        array|string $middleware = [],
    ) {
        parent::__construct(...['post', ...func_get_args()]);
    }
}
