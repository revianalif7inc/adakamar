<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Homestay;

class DemoHomestaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tiny 1x1 png (transparent)
        $pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8z8AABgAAn6cS2YAAAAASUVORK5CYII=';

        Storage::disk('public')->put('homestays/demo-photo1.png', base64_decode($pngBase64));
        Storage::disk('public')->put('homestays/demo-photo2.png', base64_decode($pngBase64));

        // create or get a demo owner
        $owner = User::firstOrCreate(
            ['email' => 'demo-owner@example.com'],
            [
                'name' => 'Demo Owner',
                'password' => bcrypt('password'),
                'role' => 'owner',
            ]
        );

        // create a demo homestay
        $h = Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Demo Kamar Multi-Gambar',
            'slug' => 'demo-kamar-multi-gambar',
            'description' => 'Kamar demo untuk pengujian slider gambar (2 foto).',
            'location' => 'Demo City',
            'price_per_night' => 120000,
            'price_per_month' => 2000000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'image_url' => 'homestays/demo-photo1.png',
            'images' => ['homestays/demo-photo1.png', 'homestays/demo-photo2.png'],
            'amenities' => ['WiFi', 'AC'],
            'is_active' => true,
        ]);

        $this->command->info('Demo homestay created with ID: ' . $h->id);
    }
}
