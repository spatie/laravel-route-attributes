<?php

namespace Spatie\RouteAttributes;

use ReflectionClass;
use Spatie\RouteAttributes\Attributes\Domain;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\RouteAttribute;
use Spatie\RouteAttributes\Attributes\Wheres;

class ClassRouteAttributes
{
    private ReflectionClass $class;

    public function __construct(ReflectionClass $class)
    {
        $this->class = $class;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function prefix(): ?string
    {
        /** @var \Spatie\RouteAttributes\Attributes\Prefix $attribute */
        if (! $attribute = $this->getAttribute(Prefix::class)) {
            return null;
        }

        return $attribute->prefix;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function domain(): ?string
    {
        /** @var \Spatie\RouteAttributes\Attributes\Domain $attribute */
        if (! $attribute = $this->getAttribute(Domain::class)) {
            return null;
        }

        return $attribute->domain;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function middleware(): array
    {
        /** @var \Spatie\RouteAttributes\Attributes\Middleware $attribute */
        if (! $attribute = $this->getAttribute(Middleware::class)) {
            return [];
        }

        return $attribute->middleware;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function wheres(): array
    {
        /** @var \Spatie\RouteAttributes\Attributes\Wheres $attribute */
        if (! $attribute = $this->getAttribute(Wheres::class)) {
            return [];
        }

        return $attribute->wheres;
    }

    protected function getAttribute(string $attributeClass): ?RouteAttribute
    {
        $attributes = $this->class->getAttributes($attributeClass);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
