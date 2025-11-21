<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\ScopeBindings;

#[ScopeBindings(false)]
class BindingScoping3TestController
{
    #[Route('get', 'explicitly-disabled-by-class/{scoped}/{binding}')]
    public function explicitlyDisabledByClassScopedBinding() {}

    #[Route('get', 'explicitly-enabled-overriding-class/{scoped}/{binding}')]
    #[ScopeBindings(true)]
    public function explicitlyEnabledOverridingClassScopedBinding() {}
}
