<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Post extends Route
{
    public function __construct(
        string $uri,
        ?string $name = null,
        array | string $middleware = [],
    ) {
        parent::__construct(
            methods: ['post'],
            uri: $uri,
            name: $name,
            middleware: $middleware,
        );
    }
}
