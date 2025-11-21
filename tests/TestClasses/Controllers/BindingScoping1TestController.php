<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\ScopeBindings;

#[ScopeBindings]
class BindingScoping1TestController
{
    #[Route('get', 'implicit/{scoped}/{binding}')]
    public function implicitlyEnabledScopedBinding() {}

    #[Route('get', 'explicitly-disabled/{scoped}/{binding}')]
    #[ScopeBindings(false)]
    public function explicitlyDisabledScopedBinding() {}
}
