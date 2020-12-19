<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\middleware;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\OtherTestmiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\Testmiddleware;

#[middleware(Testmiddleware::class)]
class middlewareTestController
{
    #[Route('get', 'single-middleware')]
    public function singlemiddleware()
    {
    }

    #[Route('get', 'multiple-middleware', middleware: OtherTestmiddleware::class)]
    public function multiplemiddleware()
    {
    }
}
