<?php

namespace Spatie\RouteAttributes;

use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use ReflectionAttribute;
use ReflectionClass;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\RouteAttribute;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Throwable;

class RouteRegistrar
{
    private Router $router;

    protected string $basePath;

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

    public function registerDirectory(array $directories): void
    {
        $files = (new Finder())->files()->in($directories);

        collect($files)->each(fn(SplFileInfo $file) => $this->processAttributes($file));
    }

    public function registerFile(string|SplFileInfo $path): void
    {
        if (is_string($path)) {
            $path = new SplFileInfo($path);
        }

        $fullyQualifiedClassName = $this->fullQualifiedClassNameFromFile($path);

        $this->processAttributes($fullyQualifiedClassName);
    }

    public function registerClass(string $class)
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

        return $class;
    }

    protected function processAttributes(string $className): void
    {
        if (!class_exists($className)) {
            return;
        }

        $reflectionClass = new ReflectionClass($className);

        $this->processClassRouteAttributes($reflectionClass);

        $this->processMethodRouteAttributes($reflectionClass);
    }

    protected function processClassRouteAttributes(ReflectionClass $class)
    {
        // TODO: implement
        $classRouteAttributes = $class->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF);
    }

    protected function processMethodRouteAttributes(ReflectionClass $class): void
    {
        foreach ($class->getMethods() as $method) {
            $attributes = $method->getAttributes();

            foreach ($attributes as $attribute) {

                try {
                    $attributeClass = $attribute->newInstance();
                } catch (Throwable) {
                    continue;
                }

                if ($attributeClass instanceof Route) {
                    $httpMethod = $attributeClass->method;

                    /** @var \Illuminate\Routing\Route $route */
                    $route = $this->router->$httpMethod($attributeClass->url, [$class->getName(), $method->getName()]);

                    $route->middleware($attributeClass->middleware);
                }
            }
        }
    }
}
