<?php

namespace Spatie\RouteAttributes\Commands;

use Illuminate\Console\Command;

class RouteAttributesCommand extends Command
{
    public $signature = 'laravel-route-attributes';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
