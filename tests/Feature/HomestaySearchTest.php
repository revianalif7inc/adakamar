<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Homestay;
use App\Models\Location;
use App\Models\User;

class HomestaySearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_by_name_returns_expected_results()
    {
        $owner = User::create([
            'name' => 'Owner Test',
            'email' => 'owner-test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);

        $loc1 = Location::create(['name' => 'Testville', 'slug' => 'testville']);
        $loc2 = Location::create(['name' => 'Othercity', 'slug' => 'othercity']);

        Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Beach House',
            'description' => 'Nice beach',
            'location' => 'Testville',
            'location_id' => $loc1->id,
            'price_per_night' => 100000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'City Studio',
            'description' => 'Downtown',
            'location' => 'Othercity',
            'location_id' => $loc2->id,
            'price_per_night' => 200000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/kamar?search=Beach');
        $response->assertStatus(200);
        $response->assertSee('Beach House');
        $response->assertDontSee('City Studio');
    }

    public function test_filter_by_location_id_returns_expected_results()
    {
        $owner = User::create([
            'name' => 'Owner Test',
            'email' => 'owner2@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);

        $loc1 = Location::create(['name' => 'Testville', 'slug' => 'testville']);
        $loc2 = Location::create(['name' => 'Othercity', 'slug' => 'othercity']);

        Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Beach House',
            'description' => 'Nice beach',
            'location' => 'Testville',
            'location_id' => $loc1->id,
            'price_per_night' => 100000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'City Studio',
            'description' => 'Downtown',
            'location' => 'Othercity',
            'location_id' => $loc2->id,
            'price_per_night' => 200000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/kamar?location_id=' . $loc2->id);
        $response->assertStatus(200);
        $response->assertSee('City Studio');
        $response->assertDontSee('Beach House');
    }
}
