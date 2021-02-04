<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\middleware;
use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\OtherTestMiddleware;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\TestMiddleware;

#[middleware(TestMiddleware::class)]
class MiddlewareTestController
{
    #[Route('get', 'single-middleware')]
    public function singlemiddleware()
    {
    }

    #[Route('get', 'multiple-middleware', middleware: OtherTestMiddleware::class)]
    public function multiplemiddleware()
    {
    }
}
