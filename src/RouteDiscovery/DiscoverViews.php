<?php

namespace Spatie\RouteAttributes\RouteDiscovery;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class DiscoverViews
{
    public function in(string $directory)
    {
        $files = (new Finder())->files()->name('*.blade.php')->in($directory);

        collect($files)->each(function (SplFileInfo $file) use ($directory) {
            $this->registerRouteForView($file, $directory);
        });
    }

    protected function registerRouteForView(SplFileInfo $file, string $baseDirectory)
    {
        $uri = Str::of($file->getPathname())
            ->after($baseDirectory)
            ->beforeLast('.blade.php');

        $view = $uri->replace('/', '.');

        $uri = Str::replaceLast('/index', '/', (string)$uri);

        $uri = collect(explode('/', $uri))
            ->map(function (string $uriSegment) {
                return Str::kebab($uriSegment);
            })
            ->join('/');

        Route::view($uri, $view);
    }
}
