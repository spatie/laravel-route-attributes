<?php

namespace ThirdParty\Http\Controllers\Api;

use Spatie\RouteAttributes\Attributes\Get;

class AnApiController
{
    #[Get('somewhere')]
    public function thirdPartyGetMethod()
    {
    }
}
