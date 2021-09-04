<?php

namespace MyOrg\MyPackage;

use Spatie\RouteAttributes\Attributes\Get;

class NamespacedTestController
{
    #[Get('my-namespaced-method')]
    public function myNamespacedMethod()
    {
    }
}
