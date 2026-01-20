<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Homestay;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin AdaKamar',
            'email' => 'admin@adakamar.id',
            'password' => Hash::make('password123'),
            'phone' => '0812345678',
            'role' => 'admin',
        ]);

        // Create Sample Owner
        $owner = User::create([
            'name' => 'Pemilik Homestay',
            'email' => 'owner@adakamar.id',
            'password' => Hash::make('password123'),
            'phone' => '0898765432',
            'role' => 'owner',
        ]);

        // Create Sample Customer
        User::create([
            'name' => 'John Doe',
            'email' => 'customer@adakamar.id',
            'password' => Hash::make('password123'),
            'phone' => '0811223344',
            'role' => 'customer',
        ]);

        // Create Sample Homestays
        Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Villa Cantik Yogyakarta',
            'description' => 'Rumah yang nyaman dan indah berlokasi di pusat Yogyakarta dengan fasilitas lengkap untuk liburan Anda.',
            'location' => 'Jl. Malioboro, Yogyakarta',
            'price_per_night' => 350000,
            'max_guests' => 6,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'image_url' => null,
            'amenities' => ['WiFi', 'AC', 'Dapur', 'Parkir Gratis', 'TV', 'Kolam Renang'],
            'rating' => 4.5,
            'is_active' => true,
        ]);

        Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Rumah Kost Bandung Modern',
            'description' => 'Kost modern dengan interior minimalis, lokasi strategis dekat dengan pusat kota Bandung.',
            'location' => 'Jl. Braga, Bandung',
            'price_per_night' => 250000,
            'max_guests' => 4,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'image_url' => null,
            'amenities' => ['WiFi', 'AC', 'Kamar Mandi Pribadi', 'Dapur Bersama'],
            'rating' => 4.0,
            'is_active' => true,
        ]);

        Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Bali Beach House',
            'description' => 'Rumah tepi pantai di Bali dengan pemandangan laut yang menakjubkan.',
            'location' => 'Jl. Pantai, Bali',
            'price_per_night' => 500000,
            'max_guests' => 8,
            'bedrooms' => 4,
            'bathrooms' => 3,
            'image_url' => null,
            'amenities' => ['WiFi', 'AC', 'Kolam Renang', 'Pantai Pribadi', 'Dapur Lengkap', 'Gym'],
            'rating' => 5.0,
            'is_active' => true,
        ]);

        // Seed articles
        $this->call(\Database\Seeders\ArticleSeeder::class);
    }
}
