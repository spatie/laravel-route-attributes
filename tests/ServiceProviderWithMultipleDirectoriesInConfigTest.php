<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\RouteAttributesServiceProvider;
use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\Grouped\GroupTestController;
use ThirdParty\Http\Controllers\Api\AnApiController;
use ThirdParty\Http\Controllers\Api\AnotherApiController;
use ThirdParty\Http\Controllers\View\AViewController;
use const DIRECTORY_SEPARATOR;

class ServiceProviderWithMultipleDirectoriesInConfigTest extends TestCase
{

    protected array $directoryConfig = [];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        require_once __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers/Api/AnApiController.php';
        require_once __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers/Api/AnotherApiController.php';
        require_once __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers/View/AViewController.php';
    }

    public function setUp(): void
    {
    }

    /** @test
     * @dataProvider configServiceProvider
     */
    public function the_provider_will_not_register_routes_multiple_times(array $config, array $expectedRoutes, int $expectedRouteCount): void
    {

        $this->directoryConfig = $config;
        $this->setUpTheTestEnvironment();
        $this->app->bind(RouteRegistrar::class, function ($app) {
            $registrar = new RouteRegistrar($app->router);
            $registrar->useBasePath($this->getTestPath('ThirdPartyTestClasses' . DIRECTORY_SEPARATOR . 'MultipleDirectoriesControllerDirectory' . DIRECTORY_SEPARATOR . 'Controllers'))
                ->useRootNamespace('ThirdParty\Http\Controllers\\')
                ->registerDirectory($this->getTestPath('ThirdPartyTestClasses' . DIRECTORY_SEPARATOR . 'MultipleDirectoriesControllerDirectory' . DIRECTORY_SEPARATOR . 'Controllers'));
            return $registrar;
        });
        $this->routeRegistrar = app(RouteRegistrar::class);
        $this->assertRegisteredRoutesCount($expectedRouteCount);

        foreach ($expectedRoutes as $registeredRoute) {
            $this->assertRouteRegistered(...$registeredRoute);
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            RouteAttributesServiceProvider::class,
        ];
    }

    protected function configServiceProvider(): array

    {
        return [
            'config like in readme will resolve as expected' => [
                'config' => [
                    __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers',

                    __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers/Api' => [
                        'middleware' => ['api'],
                        'prefix' => 'api'
                    ],
                    __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers/View' => [
                        'middleware' => 'web'
                    ],
                ],
                'expectedRoutes' => [
                    [AViewController::class, 'thirdPartyGetMethod', 'get', 'somehow', ['SomeMiddleware', 'web']],
                    [AnApiController::class, 'thirdPartyGetMethod', 'get', 'somewhere', ['SomeMiddleware', 'api']],
                    [AnotherApiController::class, 'thirdPartyGetMethod', 'get', 'somewhen', ['SomeMiddleware', 'api']]
                ],
                'expectedRouteCount' => 3
            ],
            'changing the order will change the matching since global dir will resolve first' => [
                'config' => [
                    __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers/View' => [
                        'middleware' => 'web'
                    ],
                    __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers/Api' => [
                        'middleware' => ['api'],
                        'prefix' => 'api'
                    ],
                    __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers',
                ],
                'expectedRoutes' => [
                    [AViewController::class, 'thirdPartyGetMethod', 'get', 'somehow','SomeMiddleware'],
                    [AnApiController::class, 'thirdPartyGetMethod', 'get', 'somewhere','SomeMiddleware'],
                    [AnotherApiController::class, 'thirdPartyGetMethod', 'get', 'somewhen','SomeMiddleware']
                ],
                'expectedRouteCount' => 3
            ],

            'just passing the parent directory will still resolve all routes' => [
                'config' => [
                    __DIR__ . '/ThirdPartyTestClasses/MultipleDirectoriesControllerDirectory/Controllers',
                ],
                'expectedRoutes' => [
                    [AViewController::class, 'thirdPartyGetMethod', 'get', 'somehow', 'SomeMiddleware'],
                    [AnApiController::class, 'thirdPartyGetMethod', 'get', 'somewhere', 'SomeMiddleware'],
                    [AnotherApiController::class, 'thirdPartyGetMethod', 'get', 'somewhen', 'SomeMiddleware']
                ],
                'expectedRouteCount' => 3
            ],

        ];
    }

    /**
     * Resolve application core configuration implementation.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('route-attributes.middleware', ['SomeMiddleware']);
        $app['config']->set('route-attributes.directories', $this->directoryConfig);
    }
}
