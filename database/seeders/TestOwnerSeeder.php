<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Homestay;

class TestOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if test owner already exists
        $owner = User::where('email', 'testowner@adakamar.id')->first();
        
        if (!$owner) {
            // Create test owner
            $owner = User::create([
                'name' => 'Test Owner',
                'email' => 'testowner@adakamar.id',
                'password' => bcrypt('password'),
                'phone' => '08123456789',
                'role' => 'owner',
            ]);
            
            echo "Test owner created with ID: {$owner->id}\n";
            
            // Create test homestay
            $homestay = Homestay::create([
                'owner_id' => $owner->id,
                'name' => 'Test Homestay',
                'description' => 'This is a test homestay',
                'location' => 'Jakarta',
                'price_per_night' => 250000,
                'max_guests' => 4,
                'is_active' => true,
            ]);
            
            echo "Test homestay created with ID: {$homestay->id}\n";
        } else {
            echo "Test owner already exists with ID: {$owner->id}\n";
        }
    }
}
