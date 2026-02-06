<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Homestay;
use Illuminate\Support\Facades\Storage;

class DebugHomestays extends Command
{
    protected $signature = 'debug:homestays';
    protected $description = 'Debug homestay images';

    public function handle()
    {
        $homestays = Homestay::all();

        $this->info("=== HOMESTAY DEBUG ===\n");

        foreach ($homestays as $h) {
            $gallery = $h->gallery ?? [];
            $this->info("\n[ID {$h->id}] {$h->name}");
            $this->info("  image_url: " . ($h->image_url ?? 'NULL'));
            $this->info("  images array: " . json_encode($h->images ?? []));
            $this->info("  gallery (processed): " . json_encode($gallery));
            $this->info("  is_active: " . ($h->is_active ? 'YES' : 'NO'));

            if ($h->image_url) {
                $exists = Storage::disk('public')->exists($h->image_url) ? 'YES' : 'NO';
                $this->info("  File exists: {$exists}");
            }
        }
    }
}
