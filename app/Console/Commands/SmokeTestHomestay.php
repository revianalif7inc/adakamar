<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Homestay;

class SmokeTestHomestay extends Command
{
    protected $signature = 'smoke:homestay';
    protected $description = 'Smoke test: create owner and homestay, toggle confirmation';

    public function handle()
    {
        $email = 'test_owner@example.com';

        $user = User::firstWhere('email', $email);
        if (!$user) {
            $user = User::create([
                'name' => 'Test Owner',
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'owner',
            ]);
            $this->info("Created test owner with id={$user->id}");
        } else {
            $this->info("Found existing test owner id={$user->id}");
        }

        $homestay = Homestay::create([
            'owner_id' => $user->id,
            'name' => 'Smoke Test Homestay (Owner)',
            'description' => 'Temporary homestay created by smoke test',
            'location' => 'SmokeTown',
            'price_per_night' => 123456.00,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => false,
        ]);

        $this->info("Created homestay id={$homestay->id} is_active=" . ($homestay->is_active ? '1' : '0'));

        // Simulate admin confirming
        $homestay->is_active = true;
        $homestay->save();

        $this->info("After confirm homestay id={$homestay->id} is_active=" . ($homestay->fresh()->is_active ? '1' : '0'));

        return 0;
    }
}
