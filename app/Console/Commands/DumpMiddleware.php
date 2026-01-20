<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DumpMiddleware extends Command
{
    protected $signature = 'debug:middleware';
    protected $description = 'Dump route middleware mapping from Kernel';

    public function handle()
    {
        $ref = new \ReflectionClass(\App\Http\Kernel::class);
        $props = $ref->getDefaultProperties();
        $this->info('routeMiddleware:');
        foreach (($props['routeMiddleware'] ?? []) as $k => $v) {
            $this->line(" - $k => $v");
        }
        return 0;
    }
}
