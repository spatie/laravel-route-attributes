<?php

namespace ThirdParty\Http\Controllers\View;

use Spatie\RouteAttributes\Attributes\Get;

class AViewController
{
    #[Get('somehow')]
    public function thirdPartyGetMethod()
    {
    }
}
