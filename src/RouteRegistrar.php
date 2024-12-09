<?php

namespace Spatie\RouteAttributes;

use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use Spatie\RouteAttributes\Attributes\Defaults;
use Spatie\RouteAttributes\Attributes\Fallback;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\RouteAttribute;
use Spatie\RouteAttributes\Attributes\ScopeBindings;
use Spatie\RouteAttributes\Attributes\WhereAttribute;
use Spatie\RouteAttributes\Attributes\WithTrashed;
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
        $this->rootNamespace = rtrim(str_replace('/', '\\', $rootNamespace), '\\') . '\\';

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

    public function registerDirectory(string | array $directories, array $patterns = [], array $notPatterns = []): void
    {
        $directories = Arr::wrap($directories);
        $patterns = $patterns ?: ['*.php'];

        $files = (new Finder())->files()->in($directories)->name($patterns)->notName($notPatterns)->sortByName();

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

        $groups = $classRouteAttributes->groups();

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
        foreach ($class->getMethods() as $method) {
            list($attributes, $wheresAttributes, $defaultAttributes, $fallbackAttributes, $scopeBindingsAttribute, $withTrashedAttribute) = $this->getAttributesForTheMethod($method);


            foreach ($attributes as $attribute) {
                try {
                    $attributeClass = $attribute->newInstance();
                } catch (Throwable) {
                    continue;
                }

                if (! $attributeClass instanceof Route) {
                    continue;
                }


                list($httpMethods, $action) = $this->getHTTPMethodsAndAction($attributeClass, $method, $class);


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

    /**
     * @param ReflectionAttribute|null $scopeBindingsAttribute
     * @param \Illuminate\Routing\Route $route
     * @param ClassRouteAttributes $classRouteAttributes
     * @return void
     */
    public function setScopeBindingsIfAvailable(?ReflectionAttribute $scopeBindingsAttribute, \Illuminate\Routing\Route $route, ClassRouteAttributes $classRouteAttributes): void
    {
        $scopeBindings = $scopeBindingsAttribute
            ? $scopeBindingsAttribute->newInstance()->scopeBindings
            : $classRouteAttributes->scopeBindings();

        match ($scopeBindings) {
            true => $route->scopeBindings(),
            false => $route->withoutScopedBindings(),
            null => null
        };
    }

    /**
     * @param \ReflectionMethod $method
     * @return array
     */
    public function getAttributesForTheMethod(\ReflectionMethod $method): array
    {
        $attributes = $method->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF);
        $wheresAttributes = $method->getAttributes(WhereAttribute::class, ReflectionAttribute::IS_INSTANCEOF);
        $defaultAttributes = $method->getAttributes(Defaults::class, ReflectionAttribute::IS_INSTANCEOF);
        $fallbackAttributes = $method->getAttributes(Fallback::class, ReflectionAttribute::IS_INSTANCEOF);
        $scopeBindingsAttribute = $method->getAttributes(ScopeBindings::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;
        $withTrashedAttribute = $method->getAttributes(WithTrashed::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

        return [$attributes, $wheresAttributes, $defaultAttributes, $fallbackAttributes, $scopeBindingsAttribute, $withTrashedAttribute];
    }

    /**
     * @param ClassRouteAttributes $classRouteAttributes
     * @param mixed $wheresAttributes
     * @param \Illuminate\Routing\Route $route
     * @return void
     */
    public function setWheresIfAvailable(ClassRouteAttributes $classRouteAttributes, mixed $wheresAttributes, \Illuminate\Routing\Route $route): void
    {
        $wheres = $classRouteAttributes->wheres();
        foreach ($wheresAttributes as $wheresAttribute) {
            $wheresAttributeClass = $wheresAttribute->newInstance();
            $wheres[$wheresAttributeClass->param] = $wheresAttributeClass->constraint;
        }
        if (! empty($wheres)) {
            $route->setWheres($wheres);
        }
    }

    /**
     * @param Route $attributeClass
     * @param \ReflectionMethod $method
     * @param ReflectionClass $class
     * @return array
     */
    public function getHTTPMethodsAndAction(Route $attributeClass, \ReflectionMethod $method, ReflectionClass $class): array
    {
        $httpMethods = $attributeClass->methods;
        $action = $method->getName() === '__invoke' ? $class->getName() : [$class->getName(), $method->getName()];

        return [$httpMethods, $action];
    }

    /**
     * @param ClassRouteAttributes $classRouteAttributes
     * @param Route $attributeClass
     * @param \Illuminate\Routing\Route $route
     * @return void
     */
    public function addMiddlewareToRoute(ClassRouteAttributes $classRouteAttributes, Route $attributeClass, \Illuminate\Routing\Route $route): void
    {
        $classMiddleware = $classRouteAttributes->middleware();
        $methodMiddleware = $attributeClass->middleware;
        $route->middleware([...$this->middleware, ...$classMiddleware, ...$methodMiddleware]);
    }

    /**
     * @param ClassRouteAttributes $classRouteAttributes
     * @param Route $attributeClass
     * @param \Illuminate\Routing\Route $route
     * @return void
     */
    private function addWithoutMiddlewareToRoute(ClassRouteAttributes $classRouteAttributes, Route $attributeClass, \Illuminate\Routing\Route $route): void
    {
        $methodWithoutMiddleware = $attributeClass->withoutMiddleware;
        $route->withoutMiddleware($methodWithoutMiddleware);
    }

    /**
     * @param ClassRouteAttributes $classRouteAttributes
     * @param mixed $defaultAttributes
     * @param \Illuminate\Routing\Route $route
     * @return void
     */
    public function setDefaultsIfAvailable(ClassRouteAttributes $classRouteAttributes, mixed $defaultAttributes, \Illuminate\Routing\Route $route): void
    {
        $defaults = $classRouteAttributes->defaults();
        foreach ($defaultAttributes as $defaultAttribute) {
            $defaultAttributeClass = $defaultAttribute->newInstance();

            $defaults[$defaultAttributeClass->key] = $defaultAttributeClass->value;
        }
        if (! empty($defaults)) {
            $route->setDefaults($defaults);
        }
    }

    /**
     * @param ClassRouteAttributes $classRouteAttributes
     * @param ReflectionAttribute|null $withTrashedAttribute
     * @param \Illuminate\Routing\Route $route
     * @return void
     */
    public function setWithTrashedIfAvailable(ClassRouteAttributes $classRouteAttributes, ?ReflectionAttribute $withTrashedAttribute, \Illuminate\Routing\Route $route): void
    {
        $withTrashed = $classRouteAttributes->withTrashed();


        if ($withTrashedAttribute !== null) {
            /** @var WithTrashed $instance */
            $instance = $withTrashedAttribute->newInstance();
            $route->withTrashed($instance->withTrashed);
        } else {
            $route->withTrashed($withTrashed);
        }
    }

    /**
     * @param ReflectionClass $class
     * @param ClassRouteAttributes $classRouteAttributes
     * @return \Closure
     */
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
