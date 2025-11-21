<?php

namespace ThirdParty\Http\Controllers;

use Spatie\RouteAttributes\Attributes\Get;

class ThirdPartyController
{
    #[Get('third-party')]
    public function thirdPartyGetMethod() {}
}
