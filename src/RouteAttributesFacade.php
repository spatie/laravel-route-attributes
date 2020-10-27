<?php

namespace Spatie\RouteAttributes;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\RouteAttributes\RouteAttributes
 */
class RouteAttributesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-route-attributes';
    }
}
