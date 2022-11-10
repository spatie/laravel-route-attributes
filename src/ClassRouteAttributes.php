<?php

namespace Spatie\RouteAttributes;

use ReflectionClass;
use Spatie\RouteAttributes\Attributes\Defaults;
use Spatie\RouteAttributes\Attributes\Domain;
use Spatie\RouteAttributes\Attributes\DomainFromConfig;
use Spatie\RouteAttributes\Attributes\Group;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Resource;
use Spatie\RouteAttributes\Attributes\RouteAttribute;
use Spatie\RouteAttributes\Attributes\ScopeBindings;
use Spatie\RouteAttributes\Attributes\Where;

class ClassRouteAttributes
{
    public function __construct(
        private ReflectionClass $class
    ) {
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function prefix(): ?string
    {
        /** @var \Spatie\RouteAttributes\Attributes\Prefix $attribute */
        $attribute = $this->getAttribute(Prefix::class);
        if ($attribute !== null) {
            return $attribute->prefix;
        }

        return optional($this->parent())->prefix();
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function domain(): ?string
    {
        /** @var \Spatie\RouteAttributes\Attributes\Domain $attribute */
        $attribute = $this->getAttribute(Domain::class);
        if ($attribute !== null) {
            return $attribute->domain;
        }

        return optional($this->parent())->domain();
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function domainFromConfig(): ?string
    {
        /** @var \Spatie\RouteAttributes\Attributes\DomainFromConfig $attribute */
        if (! $attribute = $this->getAttribute(DomainFromConfig::class)) {
            return null;
        }

        return config($attribute->domain);
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function groups($withDefault = true): array
    {
        $groups = [];

        /** @var ReflectionClass[] $attributes */
        $attributes = $this->class->getAttributes(Group::class, \ReflectionAttribute::IS_INSTANCEOF);
        if (count($attributes) > 0) {
            foreach ($attributes as $attribute) {
                $attributeClass = $attribute->newInstance();
                $groups[] = [
                    'domain' => $attributeClass->domain,
                    'prefix' => $attributeClass->prefix,
                    'where' => $attributeClass->where,
                    'as' => $attributeClass->as,
                ];
            }
        } elseif ($withDefault) {
            $parentGroups = optional($this->parent())->groups(false);
            if ($parentGroups !== null && count($parentGroups) > 0) {
                $groups = $parentGroups;
            } else {
                $groups[] = [
                    'domain' => $this->domainFromConfig() ?? $this->domain(),
                    'prefix' => $this->prefix(),
                ];
            }
        }

        return $groups;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function resource(): ?string
    {
        /** @var \Spatie\RouteAttributes\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->resource;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function parameters(): array | string | null
    {
        /** @var \Spatie\RouteAttributes\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->parameters;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function shallow(): bool | null
    {
        /** @var \Spatie\RouteAttributes\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->shallow;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function apiResource(): ?string
    {
        /** @var \Spatie\RouteAttributes\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->apiResource;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function except(): string | array | null
    {
        /** @var \Spatie\RouteAttributes\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->except;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function only(): string | array | null
    {
        /** @var \Spatie\RouteAttributes\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->only;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function names(): string | array | null
    {
        /** @var \Spatie\RouteAttributes\Attributes\Resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->names;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function middleware(): array
    {
        /** @var \Spatie\RouteAttributes\Attributes\Middleware $attribute */
        $attribute = $this->getAttribute(Middleware::class);
        if ($attribute !== null) {
            return $attribute->middleware;
        }

        return optional($this->parent())->middleware() ?? [];
    }

    public function scopeBindings(): bool
    {
        /** @var \Spatie\RouteAttributes\Attributes\ScopeBindings $attribute */
        if (! $attribute = $this->getAttribute(ScopeBindings::class)) {
            return false;
        }

        return $attribute->scopeBindings;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function wheres(): array
    {
        $wheres = [];
        /** @var ReflectionClass[] $attributes */
        $attributes = $this->class->getAttributes(Where::class, \ReflectionAttribute::IS_INSTANCEOF);
        foreach ($attributes as $attribute) {
            $attributeClass = $attribute->newInstance();
            $wheres[$attributeClass->param] = $attributeClass->constraint;
        }

        return $wheres;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function defaults(): array
    {
        $defaults = [];
        /** @var ReflectionClass[] $attributes */
        $attributes = $this->class->getAttributes(Defaults::class, \ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            $attributeClass = $attribute->newInstance();
            $defaults[$attributeClass->key] = $attributeClass->value;
        }

        return $defaults;
    }

    protected function parent(): ?self
    {
        if (($parent = $this->class->getParentClass()) === false) {
            return null;
        }

        return new self($parent);
    }

    protected function getAttribute(string $attributeClass): ?RouteAttribute
    {
        $attributes = $this->class->getAttributes($attributeClass, \ReflectionAttribute::IS_INSTANCEOF);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
