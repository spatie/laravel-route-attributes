<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Delete extends Route
{
    public array $middleware;

    public function __construct(
        public string $method,
        public ?string $name = null,
        array|string $middleware = [],
    ) {
        parent::__construct(...['delete', ...func_get_args()]);
    }
}
