<?php

return [
    /*
     *  Automatic registration of routes will only happen if this setting is `true`
     */
    'enabled' => true,

    /*
     * Controllers in these directories that have routing attributes
     * will automatically be registered.
     */
    'directories' => [
        app_path('Http/Controllers'),
    ],

    /**
     * You may have internal packages to your project which do not use the default
     * namespacing, for example in a monolith, to define specific namespaces add
     * to this array (location, namespace)
     * e.g.
     * base_path('packages/myOrg/myPackage/src/Http/Controllers') => 'MyOrg\\MyPackage\\Http\\Controllers'
     */
    'directory_namespaces' => [
       // base_path('packages/myOrg/myPackage/src/Http/Controllers') => 'MyOrg\\MyPackage\\Http\\Controllers'
    ],

    /**
     * This middleware will be applied to all routes.
     */
    'middleware' => [
        \Illuminate\Routing\Middleware\SubstituteBindings::class
    ]
];
