<?php

return [
    /*
     *  Automatic registration of routes will only happen if this setting is `true`
     */
    'enabled' => true,

    /*
     * Controllers in these directories that have routing attributes
     * will automatically be registered.
     *
     * Optionally, you can specify group configuration by using key/values
     *
     * Files in  the added directories will only be processed once.
     * When adding global directories (i.e. Http/Controllers) and Controller directories that are placed within
     * the global directory  (i.e. Http/Controllers/Api) with extra prefix &| middleware make sure to place the
     * more specific directory after the global directory (like seen in section install in readme)
     *
     */
    'directories' => [
        app_path('Http/Controllers'),
        /*
        app_path('Http/Controllers/Api') => [
           'prefix' => 'api',
           'middleware' => 'api',
        ],
        */
    ],

    /**
     * This middleware will be applied to all routes.
     */
    'middleware' => [
        \Illuminate\Routing\Middleware\SubstituteBindings::class
    ]
];
