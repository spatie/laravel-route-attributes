<?php

namespace Spatie\RouteAttributes;

use ReflectionClass;
use Spatie\Attributes\Attributes;
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
use Spatie\RouteAttributes\Attributes\WithTrashed;

class ClassRouteAttributes
{
    private string $className;

    public function __construct(
        private ReflectionClass $class
    ) {
        $this->className = $class->getName();
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function prefix(): ?string
    {
        /** @var Prefix $attribute */
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
        /** @var Domain $attribute */
        if (! $attribute = $this->getAttribute(Domain::class)) {
            return null;
        }

        return $attribute->domain;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function domainFromConfig(): ?string
    {
        /** @var DomainFromConfig $attribute */
        if (! $attribute = $this->getAttribute(DomainFromConfig::class)) {
            return null;
        }

        return config($attribute->domain);
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function groups(): array
    {
        $groups = [];

        $groupAttributes = Attributes::getAll($this->className, Group::class);
        if (count($groupAttributes) > 0) {
            foreach ($groupAttributes as $attributeClass) {
                $groups[] = array_filter([
                    'domain' => $attributeClass->domain,
                    'prefix' => $attributeClass->prefix,
                    'where' => $attributeClass->where,
                    'as' => $attributeClass->as,
                ]);
            }
        } else {
            $groups[] = array_filter([
                'domain' => $this->domainFromConfig() ?? $this->domain(),
                'prefix' => $this->prefix(),
            ]);
        }

        return $groups;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function resource(): ?string
    {
        /** @var resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->resource;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function parameters(): array|string|null
    {
        /** @var resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->parameters;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function shallow(): ?bool
    {
        /** @var resource $attribute */
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
        /** @var resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->apiResource;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function except(): string|array|null
    {
        /** @var resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->except;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function only(): string|array|null
    {
        /** @var resource $attribute */
        if (! $attribute = $this->getAttribute(Resource::class)) {
            return null;
        }

        return $attribute->only;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function names(): string|array|null
    {
        /** @var resource $attribute */
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
        /** @var Middleware $attribute */
        if (! $attribute = $this->getAttribute(Middleware::class)) {
            return [];
        }

        return $attribute->middleware;
    }

    public function scopeBindings(): ?bool
    {
        /** @var ScopeBindings $attribute */
        if (! $attribute = $this->getAttribute(ScopeBindings::class)) {
            return config('route-attributes.scope-bindings');
        }

        return $attribute->scopeBindings;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function wheres(): array
    {
        $wheres = [];
        foreach (Attributes::getAll($this->className, Where::class) as $attributeClass) {
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
        foreach (Attributes::getAll($this->className, Defaults::class) as $attributeClass) {
            $defaults[$attributeClass->key] = $attributeClass->value;
        }

        return $defaults;
    }

    /**
     * @psalm-suppress NoInterfaceProperties
     */
    public function withTrashed(): bool
    {
        /** @var ?WithTrashed $attribute */
        if (! $attribute = $this->getAttribute(WithTrashed::class)) {
            return false;
        }

        return $attribute->withTrashed;
    }

    protected function getAttribute(string $attributeClass): ?RouteAttribute
    {
        return Attributes::get($this->className, $attributeClass);
    }
}
