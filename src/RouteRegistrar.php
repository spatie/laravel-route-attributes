<?php

namespace Spatie\RouteAttributes;

use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use Spatie\Attributes\Attributes;
use Spatie\RouteAttributes\Attributes\Defaults;
use Spatie\RouteAttributes\Attributes\Fallback;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\ScopeBindings;
use Spatie\RouteAttributes\Attributes\WhereAttribute;
use Spatie\RouteAttributes\Attributes\WithTrashed;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class RouteRegistrar
{
    private Router $router;

    protected string $basePath;

    protected string $rootNamespace;

    protected array $middleware = [];

    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->useBasePath(app()->path());
    }

    public function group(array $options, $routes): self
    {
        $this->router->group($options, $routes);

        return $this;
    }

    public function useBasePath(string $basePath): self
    {
        $this->basePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $basePath);

        return $this;
    }

    public function useRootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = rtrim(str_replace('/', '\\', $rootNamespace), '\\').'\\';

        return $this;
    }

    public function useMiddleware(string|array $middleware): self
    {
        $this->middleware = Arr::wrap($middleware);

        return $this;
    }

    public function middleware(): array
    {
        return $this->middleware ?? [];
    }

    public function registerDirectory(string|array $directories, array $patterns = [], array $notPatterns = []): void
    {
        $directories = Arr::wrap($directories);
        $patterns = $patterns ?: ['*.php'];

        $files = (new Finder)->files()->in($directories)->name($patterns)->notName($notPatterns)->sortByName();

        $this
            ->collectGroupsFromFiles($files)
            ->sortByDesc(fn ($item) => ! empty($item['group']['domain'] ?? null))
            ->each(fn ($item) => $this->registerGroupedRoutes($item));
    }

    protected function collectGroupsFromFiles(Finder $files): Collection
    {
        return collect($files)
            ->map(fn ($file) => $this->fullQualifiedClassNameFromFile($file))
            ->filter(fn ($className) => class_exists($className))
            ->map(fn ($className) => [
                'class' => new ReflectionClass($className),
                'classRouteAttributes' => new ClassRouteAttributes(new ReflectionClass($className)),
            ])
            ->flatMap(fn ($item) => $this->expandClassIntoGroups($item));
    }

    protected function expandClassIntoGroups(array $classData): array
    {
        return collect($classData['classRouteAttributes']->groups())
            ->map(fn ($group) => [
                'class' => $classData['class'],
                'classRouteAttributes' => $classData['classRouteAttributes'],
                'group' => $group,
            ])
            ->all();
    }

    protected function registerGroupedRoutes(array $item): void
    {
        $this->router->group(
            $item['group'],
            fn () => $this->registerRoutes($item['class'], $item['classRouteAttributes'])
        );

        if ($item['classRouteAttributes']->resource()) {
            $this->registerResource($item['class'], $item['classRouteAttributes']);
        }
    }

    public function registerFile(string|SplFileInfo $path): void
    {
        if (is_string($path)) {
            $path = new SplFileInfo($path);
        }

        $fullyQualifiedClassName = $this->fullQualifiedClassNameFromFile($path);

        $this->processAttributes($fullyQualifiedClassName);
    }

    public function registerClass(string $class): void
    {
        $this->processAttributes($class);
    }

    protected function fullQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        $class = trim(Str::replaceFirst($this->basePath, '', $file->getRealPath()), DIRECTORY_SEPARATOR);

        $class = str_replace(
            [DIRECTORY_SEPARATOR, 'App\\'],
            ['\\', app()->getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        );

        return $this->rootNamespace.$class;
    }

    protected function processAttributes(string $className): void
    {
        if (! class_exists($className)) {
            return;
        }

        $class = new ReflectionClass($className);

        $classRouteAttributes = new ClassRouteAttributes($class);

        $groups = $classRouteAttributes->groups();

        // Note: When called from registerDirectory, groups are already globally sorted
        // This sorting is only for individual registerClass calls
        usort($groups, function (array $group1, array $group2) {
            $domain1 = ! empty($group1['domain'] ?? null);
            $domain2 = ! empty($group2['domain'] ?? null);

            return $domain2 <=> $domain1; // Domain routes come first
        });

        foreach ($groups as $group) {
            $router = $this->router;
            $router->group($group, fn () => $this->registerRoutes($class, $classRouteAttributes));
        }

        if ($classRouteAttributes->resource()) {
            $this->registerResource($class, $classRouteAttributes);
        }

    }

    protected function registerResource(ReflectionClass $class, ClassRouteAttributes $classRouteAttributes): void
    {
        $this->router->group(array_filter([
            'domain' => $classRouteAttributes->domain(),
            'prefix' => $classRouteAttributes->prefix(),
        ]), $this->getRoutes($class, $classRouteAttributes));
    }

    protected function registerRoutes(ReflectionClass $class, ClassRouteAttributes $classRouteAttributes): void
    {
        $className = $class->getName();

        foreach ($class->getMethods() as $method) {
            $methodName = $method->getName();
            [$routeAttributes, $wheresAttributes, $defaultAttributes, $fallbackAttributes, $scopeBindingsAttribute, $withTrashedAttribute] = $this->getAttributesForTheMethod($className, $methodName);

            foreach ($routeAttributes as $attributeClass) {
                [$httpMethods, $action] = $this->getHTTPMethodsAndAction($attributeClass, $method, $class);

                $route = $this->router->addRoute($httpMethods, $attributeClass->uri, $action)->name($attributeClass->name);

                $this->setScopeBindingsIfAvailable($scopeBindingsAttribute, $route, $classRouteAttributes);

                $this->setWheresIfAvailable($classRouteAttributes, $wheresAttributes, $route);

                $this->setDefaultsIfAvailable($classRouteAttributes, $defaultAttributes, $route);

                $this->addMiddlewareToRoute($classRouteAttributes, $attributeClass, $route);

                $this->addWithoutMiddlewareToRoute($classRouteAttributes, $attributeClass, $route);

                $this->setWithTrashedIfAvailable($classRouteAttributes, $withTrashedAttribute, $route);

                if (count($fallbackAttributes) > 0) {
                    $route->fallback();
                }
            }
        }
    }

    public function setScopeBindingsIfAvailable(?ScopeBindings $scopeBindingsAttribute, \Illuminate\Routing\Route $route, ClassRouteAttributes $classRouteAttributes): void
    {
        $scopeBindings = $scopeBindingsAttribute
            ? $scopeBindingsAttribute->scopeBindings
            : $classRouteAttributes->scopeBindings();

        match ($scopeBindings) {
            true => $route->scopeBindings(),
            false => $route->withoutScopedBindings(),
            null => null
        };
    }

    public function getAttributesForTheMethod(string $className, string $methodName): array
    {
        $routeAttributes = Attributes::getAllOnMethod($className, $methodName, Route::class);
        $wheresAttributes = Attributes::getAllOnMethod($className, $methodName, WhereAttribute::class);
        $defaultAttributes = Attributes::getAllOnMethod($className, $methodName, Defaults::class);
        $fallbackAttributes = Attributes::getAllOnMethod($className, $methodName, Fallback::class);
        $scopeBindingsAttribute = Attributes::onMethod($className, $methodName, ScopeBindings::class);
        $withTrashedAttribute = Attributes::onMethod($className, $methodName, WithTrashed::class);

        return [$routeAttributes, $wheresAttributes, $defaultAttributes, $fallbackAttributes, $scopeBindingsAttribute, $withTrashedAttribute];
    }

    public function setWheresIfAvailable(ClassRouteAttributes $classRouteAttributes, array $wheresAttributes, \Illuminate\Routing\Route $route): void
    {
        $wheres = $classRouteAttributes->wheres();
        foreach ($wheresAttributes as $wheresAttribute) {
            $wheres[$wheresAttribute->param] = $wheresAttribute->constraint;
        }
        if (! empty($wheres)) {
            $route->setWheres($wheres);
        }
    }

    public function getHTTPMethodsAndAction(Route $attributeClass, \ReflectionMethod $method, ReflectionClass $class): array
    {
        $httpMethods = $attributeClass->methods;
        $action = $method->getName() === '__invoke' ? $class->getName() : [$class->getName(), $method->getName()];

        return [$httpMethods, $action];
    }

    public function addMiddlewareToRoute(ClassRouteAttributes $classRouteAttributes, Route $attributeClass, \Illuminate\Routing\Route $route): void
    {
        $classMiddleware = $classRouteAttributes->middleware();
        $methodMiddleware = $attributeClass->middleware;
        $route->middleware([...$this->middleware, ...$classMiddleware, ...$methodMiddleware]);
    }

    private function addWithoutMiddlewareToRoute(ClassRouteAttributes $classRouteAttributes, Route $attributeClass, \Illuminate\Routing\Route $route): void
    {
        $methodWithoutMiddleware = $attributeClass->withoutMiddleware;
        $route->withoutMiddleware($methodWithoutMiddleware);
    }

    public function setDefaultsIfAvailable(ClassRouteAttributes $classRouteAttributes, array $defaultAttributes, \Illuminate\Routing\Route $route): void
    {
        $defaults = $classRouteAttributes->defaults();
        foreach ($defaultAttributes as $defaultAttribute) {
            $defaults[$defaultAttribute->key] = $defaultAttribute->value;
        }
        if (! empty($defaults)) {
            $route->setDefaults($defaults);
        }
    }

    public function setWithTrashedIfAvailable(ClassRouteAttributes $classRouteAttributes, ?WithTrashed $withTrashedAttribute, \Illuminate\Routing\Route $route): void
    {
        $withTrashed = $classRouteAttributes->withTrashed();

        if ($withTrashedAttribute !== null) {
            $route->withTrashed($withTrashedAttribute->withTrashed);
        } else {
            $route->withTrashed($withTrashed);
        }
    }

    public function getRoutes(ReflectionClass $class, ClassRouteAttributes $classRouteAttributes): \Closure
    {
        return function () use ($class, $classRouteAttributes) {
            $route = $classRouteAttributes->apiResource()
                ? $this->router->apiResource($classRouteAttributes->resource(), $class->getName())
                : $this->router->resource($classRouteAttributes->resource(), $class->getName());

            $methods = [
                'only',
                'except',
                'names',
                'parameters',
                'shallow',
            ];

            foreach ($methods as $method) {
                $value = $classRouteAttributes->$method();

                if ($value !== null) {
                    $route->$method($value);
                }
            }

            $route->middleware([...$this->middleware, ...$classRouteAttributes->middleware()]);
        };
    }
}
