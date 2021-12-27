<?php

namespace Spatie\RouteAttributes;

use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\RouteAttribute;
use Spatie\RouteAttributes\Attributes\Where;
use Spatie\RouteAttributes\Attributes\WhereAttribute;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Throwable;

class RouteRegistrar
{
    private Router $router;

    protected string $basePath;

    protected string $rootNamespace;

    protected array $middleware = [];

    public function __construct(Router $router)
    {
        $this->router = $router;

        $this->basePath = app()->path();
    }

    public function useBasePath(string $basePath): self
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function useRootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = $rootNamespace;

        return $this;
    }

    public function useMiddleware(string | array $middleware): self
    {
        $this->middleware = Arr::wrap($middleware);

        return $this;
    }

    public function middleware(): array
    {
        return $this->middleware ?? [];
    }

    public function registerDirectory(string | array $directories): void
    {
        $directories = Arr::wrap($directories);

        $files = (new Finder())->files()->name('*.php')->in($directories);

        collect($files)->each(fn (SplFileInfo $file) => $this->registerFile($file));
    }

    public function registerFile(string | SplFileInfo $path): void
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

        return $this->rootNamespace . $class;
    }

    protected function processAttributes(string $className): void
    {
        if (! class_exists($className)) {
            return;
        }

        $class = new ReflectionClass($className);

        $classRouteAttributes = new ClassRouteAttributes($class);

        if ($classRouteAttributes->resource()) {
            $this->registerResource($class, $classRouteAttributes);

            return;
        }

        $groups = $classRouteAttributes->groups();

        foreach ($groups as $group) {
            $router = $this->router;
            $router->group($group, fn () => $this->registerRoutes($class, $classRouteAttributes));
        }
    }

    protected function registerResource(ReflectionClass $class, ClassRouteAttributes $classRouteAttributes): void
    {
        $this->router->group([
            'domain' => $classRouteAttributes->domain(),
            'prefix' => $classRouteAttributes->prefix(),
        ], function () use ($class, $classRouteAttributes) {
            $route = $classRouteAttributes->apiResource()
                ? $this->router->apiResource($classRouteAttributes->resource(), $class->getName())
                : $this->router->resource($classRouteAttributes->resource(), $class->getName());

            if ($only = $classRouteAttributes->only()) {
                $route->only($only);
            }

            if ($except = $classRouteAttributes->except()) {
                $route->except($except);
            }

            if ($names = $classRouteAttributes->names()) {
                $route->names($names);
            }

            if ($middleware = $classRouteAttributes->middleware()) {
                $route->middleware([...$this->middleware, ...$middleware]);
            }
        });
    }

    protected function registerRoutes(
        ReflectionClass      $class,
        ClassRouteAttributes $classRouteAttributes
    ): void {
        foreach ($class->getMethods() as $method) {
            $attributes = $method->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF);
            $wheresAttributes = $method->getAttributes(WhereAttribute::class, ReflectionAttribute::IS_INSTANCEOF);

            if (! count($attributes)) {
                $attributes = [Route::new()];
            }

            foreach ($attributes as $attribute) {
                try {
                    $attributeClass = $attribute;

                    if ($attributeClass instanceof ReflectionAttribute) {
                        $attributeClass = $attribute->newInstance();
                    }
                } catch (Throwable $exception) {
                    continue;
                }

                if (! $attributeClass instanceof Route) {
                    $attributeClass = Route::new();
                }

                $uri = $attributeClass->uri;
                $httpMethods = $attributeClass->methods;

                if (! $uri) {
                    $uri = $this->autoDiscoverUri($class, $method);
                    $httpMethods = $this->autoDiscoverHttpMethods($class, $method);
                }

                if (! $uri) {
                    continue;
                }

                $action = $method->getName() === '__invoke'
                    ? $class->getName()
                    : [$class->getName(), $method->getName()];

                $route = $this->router
                    ->addRoute(
                        $httpMethods,
                        $uri,
                        $action,
                    )
                    ->name($attributeClass->name);

                $wheres = $classRouteAttributes->wheres();
                foreach ($wheresAttributes as $wheresAttribute) {
                    /** @var Where $wheresAttributeClass */
                    $wheresAttributeClass = $wheresAttribute->newInstance();

                    // This also overrides class wheres if the same param is used
                    $wheres[$wheresAttributeClass->param] = $wheresAttributeClass->constraint;
                }
                if (! empty($wheres)) {
                    $route->setWheres($wheres);
                }

                $classMiddleware = $classRouteAttributes->middleware();
                $methodMiddleware = $attributeClass->middleware;
                $route->middleware([...$this->middleware, ...$classMiddleware, ...$methodMiddleware]);
            }
        }
    }

    protected function autoDiscoverHttpMethods(ReflectionClass $class, ReflectionMethod $method): ?array
    {
        return match ($method->name) {
            'index', 'get' => ['GET'],
            default => null,
        };
    }

    protected function autoDiscoverUri(ReflectionClass $class, ReflectionMethod $method): ?string
    {
        $parts =  Str::of($class->getName())
            ->after($this->rootNamespace)
            ->beforeLast('Controller')
            ->explode('\\');

        return collect($parts)
            ->map(function(string $part) {
                return Str::of($part)->kebab();
            })
            ->implode('/');
    }
}
