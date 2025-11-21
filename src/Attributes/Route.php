<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Route implements RouteAttribute
{
    public array $methods;

    public array $middleware;

    public array $withoutMiddleware;

    public function __construct(
        array|string $methods,
        public string $uri,
        public ?string $name = null,
        array|string $middleware = [],
        array|string $withoutMiddleware = [],
    ) {
        $this->methods = array_map(
            static fn (string $verb) => in_array(
                $upperVerb = strtoupper($verb),
                Router::$verbs
            )
            ? $upperVerb
            : $verb,
            Arr::wrap($methods)
        );
        $this->middleware = Arr::wrap($middleware);
        $this->withoutMiddleware = Arr::wrap($withoutMiddleware);
    }
}
