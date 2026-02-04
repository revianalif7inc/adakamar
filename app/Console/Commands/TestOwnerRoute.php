<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestOwnerRoute extends Command
{
    protected $signature = 'test:owner-route';
    protected $description = 'Test owner profile route';

    public function handle()
    {
        $this->info('Testing owner.profile route...');

        try {
            $url = route('owner.profile', ['id' => 1]);
            $this->info('✓ Route generated successfully: ' . $url);
        } catch (\Exception $e) {
            $this->error('✗ Route generation failed: ' . $e->getMessage());
        }
    }
}
