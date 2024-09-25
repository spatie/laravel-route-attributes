# Use PHP 8 attributes to register routes in a Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-route-attributes.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-route-attributes)
![Tests](https://github.com/spatie/laravel-route-attributes/workflows/Tests/badge.svg)
[![Type Coverage](https://shepherd.dev/github/spatie/laravel-route-attributes/coverage.svg)](https://shepherd.dev/github/spatie/laravel-route-attributes)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-route-attributes.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-route-attributes)

This package provides attributes to automatically register routes. Here's a quick example:

```php
use Spatie\RouteAttributes\Attributes\Get;

class MyController
{
    #[Get('my-route')]
    public function myMethod()
    {
    }
}
```

This attribute will automatically register this route:

```php
Route::get('my-route', [MyController::class, 'myMethod']);
```

## Are you a visual learner?

[In this video](https://spatie.be/videos/front-line-php/adding-meta-data-using-attributes) you'll get an introduction to PHP 8 attributes and how this laravel-routes-attributes works under the hood.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-route-attributes.jpg?t=2" width="419px" />](https://spatie.be/github-ad-click/laravel-route-attributes)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-route-attributes
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\RouteAttributes\RouteAttributesServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
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
     */
    'directories' => [
        app_path('Http/Controllers'),

        app_path('Http/Controllers/Web') => [
            'middleware' => ['web']
        ],

        app_path('Http/Controllers/Api') => [
            'prefix' => 'api',
            'middleware' => 'api'
        ],
    ],
];
```

For controllers outside the applications root namespace directories can also be added using a `namespace => path` pattern in the directories array. In the following example controllers from `Modules\Admin\Http\Controllers` will be included.

```php
'directories' => [
    'Modules\Admin\Http\Controllers\\' => base_path('admin-module/Http/Controllers'),
    // Or
    base_path('admin-module/Http/Controllers') => [
        'namespace' => 'Modules\Admin\Http\Controllers\\'
    ],
    app_path('Http/Controllers'),
],
```

If you are using a directory structure where you co-locate multiple types of files in the same directory and want to
be more specific about which files are checked for route attributes, you can use the `patterns` and `not_patterns`
options. For example, if you are co-locating your tests with your controllers you could use the `patterns` option to only
look in controller files, or you could use `not_patterns` to configure it to not look in test files for route
attributes.

```php
'directories' => [
    base_path('app-modules/Blog') => [
        // only register routes in files that match the patterns
        'patterns' => ['*Controller.php'],
        // do not register routes in files that match the patterns
        'not_patterns' => ['*Test.php'],
    ],
],
```

## Usage

The package provides several annotations that should be put on controller classes and methods. These annotations will be used to automatically register routes

### Adding a GET route

```php
use Spatie\RouteAttributes\Attributes\Get;

class MyController
{
    #[Get('my-route')]
    public function myMethod()
    {

    }
}
```

This attribute will automatically register this route:

```php
Route::get('my-route', [MyController::class, 'myMethod']);
```

### Using other HTTP verbs

We have left no HTTP verb behind. You can use these attributes on controller methods.

```php
#[Spatie\RouteAttributes\Attributes\Post('my-uri')]
#[Spatie\RouteAttributes\Attributes\Put('my-uri')]
#[Spatie\RouteAttributes\Attributes\Patch('my-uri')]
#[Spatie\RouteAttributes\Attributes\Delete('my-uri')]
#[Spatie\RouteAttributes\Attributes\Options('my-uri')]
```

### Resource controllers

To register a [resource controller](https://laravel.com/docs/controllers#resource-controllers), use the `Resource` attribute as shown in the example below.

You can use `only` or `except` parameters to manage your resource routes availability.

You can use `parameters` parameter to modify the default parameters set by the resource attribute.

You can use the `names` parameter to set the route names for the resource controller actions. Pass a string value to set a base route name for each controller action or pass an array value to define the route name for each controller action.

You can use `shallow` parameter to make a nested resource to apply nesting only to routes without a unique child identifier (`index`, `create`, `store`).

You can use `apiResource` boolean parameter to only include actions used in APIs. Alternatively, you can use the `ApiResource` attribute, which extends the `Resource` attribute class, but the parameter `apiResource` is already set to `true`.

Using `Resource` attribute with `Domain`, `Prefix` and `Middleware` attributes works as well.

```php
use Spatie\RouteAttributes\Attributes\Resource;

#[Prefix('api/v1')]
#[Resource(
    resource: 'photos.comments',
    apiResource: true,
    shallow: true,
    parameters: ['comments' => 'comment:uuid'],
    names: 'api.v1.photoComments',
    except: ['destroy'],
)]
// OR #[ApiResource(resource: 'photos.comments', shallow: true, ...)]
class PhotoCommentController
{
    public function index(Photo $photo)
    {
    }

    public function store(Request $request, Photo $photo)
    {
    }

    public function show(Comment $comment)
    {
    }

    public function update(Request $request, Comment $comment)
    {
    }
}
```

The attribute in the example above will automatically register following routes:

```php
Route::get('api/v1/photos/{photo}/comments', [PhotoCommentController::class, 'index'])->name('api.v1.photoComments.index');
Route::post('api/v1/photos/{photo}/comments', [PhotoCommentController::class, 'store'])->name('api.v1.photoComments.store');
Route::get('api/v1/comments/{comment}', [PhotoCommentController::class, 'show'])->name('api.v1.photoComments.show');
Route::match(['put', 'patch'], 'api/v1/comments/{comment}', [PhotoCommentController::class, 'update'])->name('api.v1.photoComments.update');
```

### Using multiple verbs

To register a route for all verbs, you can use the `Any` attribute:

```php
#[Spatie\RouteAttributes\Attributes\Any('my-uri')]
```

To register a route for a few verbs at once, you can use the `Route` attribute directly:

```php
#[Spatie\RouteAttributes\Attributes\Route(['put', 'patch'], 'my-uri')]
```

### Specify a route name

All HTTP verb attributes accept a parameter named `name` that accepts a route name.

```php
use Spatie\RouteAttributes\Attributes\Get;

class MyController
{
    #[Get('my-route', name: "my-route-name")]
    public function myMethod()
    {
    }
}
```

This attribute will automatically register this route:

```php
Route::get('my-route', [MyController::class, 'myMethod'])->name('my-route-name');
```

### Adding middleware

All HTTP verb attributes accept a parameter named `middleware` that accepts a middleware class or an array of middleware classes.

```php
use Spatie\RouteAttributes\Attributes\Get;

class MyController
{
    #[Get('my-route', middleware: MyMiddleware::class)]
    public function myMethod()
    {

    }
}
```

This annotation will automatically register this route:

```php
Route::get('my-route', [MyController::class, 'myMethod'])->middleware(MyMiddleware::class);
```

To apply middleware on all methods of a class you can use the `Middleware` attribute. You can mix this with applying attribute on a method.

```php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware(MyMiddleware::class)]
class MyController
{
    #[Get('my-route')]
    public function firstMethod()
    {
    }

    #[Get('my-other-route', middleware: MyOtherMiddleware::class)]
    public function secondMethod()
    {
    }
}
```

These annotations will automatically register these routes:

```php
Route::get('my-route', [MyController::class, 'firstMethod'])->middleware(MyMiddleware::class);
Route::get('my-other-route', [MyController::class, 'secondMethod'])->middleware([MyMiddleware::class, MyOtherMiddleware::class]);
```

### Specifying a prefix

You can use the `Prefix` annotation on a class to prefix the routes of all methods of that class.

```php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Prefix('my-prefix')]
class MyController
{
    #[Get('my-get-route')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-route')]
    public function myPostMethod()
    {
    }
}
```

These annotations will automatically register these routes:

```php
Route::get('my-prefix/my-get-route', [MyController::class, 'myGetMethod']);
Route::post('my-prefix/my-post-route', [MyController::class, 'myPostMethod']);
```

### Specifying a domain

You can use the `Domain` annotation on a class to prefix the routes of all methods of that class.

```php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Domain;

#[Domain('my-subdomain.localhost')]
class MyController
{
    #[Get('my-get-route')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-route')]
    public function myPostMethod()
    {
    }
}
```

These annotations will automatically register these routes:

```php
Route::get('my-get-route', [MyController::class, 'myGetMethod'])->domain('my-subdomain.localhost');
Route::post('my-post-route', [MyController::class, 'myPostMethod'])->domain('my-subdomain.localhost');
```

### Specifying a domain from a config key

There maybe a need to define a domain from a configuration file, for example where
your subdomain will be different on your development environment to your production environment.


```php
// config/domains.php
return [
    'main' => env('SITE_URL', 'example.com'),
    'subdomain' => env('SUBDOMAIN_URL', 'subdomain.example.com')
];
```

```php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\DomainFromConfig;

#[DomainFromConfig('domains.main')]
class MyController
{
    #[Get('my-get-route')]
    public function myGetMethod()
    {
    }
}
```
When this is parsed, it will get the value of `domains.main` from the config file and
register the route as follows;

```php
Route::get('my-get-route', [MyController::class, 'myGetMethod'])->domain('example.com');
```

### Scoping bindings

When implicitly binding multiple Eloquent models in a single route definition, you may wish to scope the second Eloquent model such that it must be a child of the previous Eloquent model.

By adding the `ScopeBindings` annotation, you can enable this behaviour:

````php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\ScopeBindings;

class MyController
{
    #[Get('users/{user}/posts/{post}')]
    #[ScopeBindings]
    public function getUserPost(User $user, Post $post)
    {
        return $post;
    }
}
````

This is akin to using the `->scopeBindings()` method on the route registrar manually:

```php
Route::get('/users/{user}/posts/{post}', function (User $user, Post $post) {
    return $post;
})->scopeBindings();
```

By default, Laravel will enabled scoped bindings on a route when using a custom keyed implicit binding as a nested route parameter, such as `/users/{user}/posts/{post:slug}`.

To disable this behaviour, you can pass `false` to the attribute:

```php
#[ScopeBindings(false)]
```

This is the equivalent of calling `->withoutScopedBindings()` on the route registrar manually.

You can also use the annotation on controllers to enable implicitly scoped bindings for all its methods. For any methods where you want to override this, you can pass `false` to the attribute on those methods, just like you would normally.

### Specifying where

You can use the `Where` annotation on a class or method to constrain the format of your route parameters.


```php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Where;
use Spatie\RouteAttributes\Attributes\WhereAlphaNumeric;

#[Where('my-where', '[0-9]+')]
class MyController
{
    #[Get('my-get-route/{my-where}')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-route/{my-where}/{my-alpha-numeric}')]
    #[WhereAlphaNumeric('my-alpha-numeric')]
    public function myPostMethod()
    {
    }
}
```

These annotations will automatically register these routes:

```php
Route::get('my-get-route/{my-where}', [MyController::class, 'myGetMethod'])->where(['my-where' => '[0-9]+']);
Route::post('my-post-route/{my-where}/{my-alpha-numeric}', [MyController::class, 'myPostMethod'])->where(['my-where' => '[0-9]+', 'my-alpha-numeric' => '[a-zA-Z0-9]+']);
```

For convenience, some commonly used regular expression patterns have helper attributes that allow you to quickly add pattern constraints to your routes.

```php
#[WhereAlpha('alpha')]
#[WhereAlphaNumeric('alpha-numeric')]
#[WhereIn('in', ['value1', 'value2'])]
#[WhereNumber('number')]
#[WhereUlid('ulid')]
#[WhereUuid('uuid')]
```

### Specifying a group

You can use the `Group` annotation on a class to create multiple groups with different domains and prefixes for the routes of all methods of that class.

```php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Domain;

#[Group(domain: 'my-subdomain.localhost', prefix: 'my-prefix')]
#[Group(domain: 'my-second-subdomain.localhost', prefix: 'my-second-prefix')]
class MyController
{
    #[Get('my-get-route')]
    public function myGetMethod()
    {
    }

    #[Post('my-post-route')]
    public function myPostMethod()
    {
    }
}
```

These annotations will automatically register these routes:

```php
Route::get('my-get-route', [MyController::class, 'myGetMethod'])->prefix('my-prefix')->domain('my-subdomain.localhost');
Route::post('my-post-route', [MyController::class, 'myPostMethod'])->prefix('my-prefix')->domain('my-subdomain.localhost');
Route::get('my-get-route', [MyController::class, 'myGetMethod'])->prefix('my-second-prefix')->domain('my-second-subdomain.localhost');
Route::post('my-post-route', [MyController::class, 'myPostMethod'])->prefix('my-second-prefix')->domain('my-second-subdomain.localhost');
```

### Specifying defaults

You can use the `Defaults` annotation on a class or method to define the default values of your optional route parameters.

```php
use Spatie\RouteAttributes\Attributes\Defaults;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;

#[Defaults('param', 'controller-default')]
class MyController extends Controller
{
    #[Get('my-get-route/{param?}')]
    public function myGetMethod($param)
    {
    }

    #[Post('my-post-route/{param?}/{param2?}')]
    #[Defaults('param2', 'method-default')]
    public function myPostMethod($param, $param2)
    {
    }

    #[Get('my-default-route/{param?}/{param2?}/{param3?}')]
    #[Defaults('param2', 'method-default-first')]
    #[Defaults('param3', 'method-default-second')]
    public function myDefaultMethod($param, $param2, $param3)
    {
    }

    #[Get('my-override-route/{param?}')]
    #[Defaults('param', 'method-default')]
    public function myOverrideMethod($param)
    {
    }
}
```

These annotations will automatically register these routes:

```php
Route::get('my-get-route/{param?}', [MyController::class, 'myGetMethod'])->setDefaults(['param', 'controller-default']);
Route::post('my-post-route/{param?}/{param2?}', [MyController::class, 'myPostMethod'])->setDefaults(['param', 'controller-default', 'param2' => 'method-default']);
Route::get('my-default-route/{param?}/{param2?}/{param3?}', [MyController::class, 'myDefaultMethod'])->setDefaults(['param', 'controller-default', 'param2' => 'method-default-first', 'param3' => 'method-default-second']);
Route::get('my-override-route/{param?}', [MyController::class, 'myOverrideMethod'])->setDefaults(['param', 'method-default']);
```

### With Trashed

You can use the `WithTrashed` annotation on a class or method to enable WithTrashed bindings to the model.
You can explicitly override the behaviour using `WithTrashed(false)` if it is applied at the class level

```php
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\WithTrashed;

#[WithTrashed]
class MyController extends Controller
{
    #[Get('my-get-route/{param}')]
    #[WithTrashed]
    public function myGetMethod($param)
    {
    }

    #[Post('my-post-route/{param}')]
    #[WithTrashed(false)]    
    public function myPostMethod($param)
    {
    }

    #[Get('my-default-route/{param}')]
    public function myDefaultMethod($param)
    {
    }    
}
```
These annotations will automatically register these routes:

```php
Route::get('my-get-route/{param}', [MyController::class, 'myGetMethod'])->WithTrashed();
Route::post('my-post-route/{param}', [MyController::class, 'myPostMethod'])->withTrashed(false);
Route::get('my-default-route/{param}', [MyController::class, 'myDefaultMethod'])->withTrashed();
```


## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
