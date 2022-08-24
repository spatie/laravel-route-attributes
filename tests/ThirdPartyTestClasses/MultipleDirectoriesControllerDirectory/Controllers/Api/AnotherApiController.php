<?php

namespace ThirdParty\Http\Controllers\Api;

use Spatie\RouteAttributes\Attributes\Get;

class AnotherApiController
{
    #[Get('somewhen')]
    public function thirdPartyGetMethod()
    {
    }
}
