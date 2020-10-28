<?php

namespace Spatie\RouteAttributes;

use ReflectionClass;
use Spatie\RouteAttributes\Attributes\Prefix;

class ClassRouteAttributes
{
    private ReflectionClass $class;

    public function __construct(ReflectionClass $class)
    {
        $this->class = $class;
    }

    public function prefix(): ?string
    {

        $attributes = $this->class->getAttributes(Prefix::class);

        if (! count($attributes)) {
            return null;
        }

        /** @var Prefix $prefixAttribute */
        $prefixAttribute  = $attributes[0]->newInstance();

        return $prefixAttribute->prefix;
    }
}
