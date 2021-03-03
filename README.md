# Use PHP 8 attributes to register routes in a Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-route-attributes.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-route-attributes)
![Tests](https://github.com/spatie/laravel-route-attributes/workflows/Tests/badge.svg)
[![Type Coverage](https://shepherd.dev/github/spatie/laravel-route-attributes/coverage.svg)](https://shepherd.dev/github/spatie/laravel-route-attributes)

This package provides annotations to automatically register routes. Here's a quick example:

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
     */
    'directories' => [
        app_path('Http/Controllers'),
    ],
];
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
Route::get('my-other-route', [MyController::class, 'secondMethod'])->middleware([MyMiddleware::class, MyOtherMiddleware]);
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

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
