<?php

namespace Spatie\RouteAttributes\Tests;

use Spatie\RouteAttributes\Tests\TestClasses\Controllers\PatchControllerTest;

class PatchAttributeTest extends TestCase
{
    /** @test */
    public function it_can_register_a_patch_route()
    {
        $this->routeRegistrar->registerClass(PatchControllerTest::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(PatchControllerTest::class, 'myPatchMethod', 'patch', 'my-patch-method');
    }
}
