<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Homestay;
use App\Models\Booking;

class OwnerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_dashboard_shows_only_own_homestays_and_bookings()
    {
        // Create two owners
        $owner1 = User::create(['name' => 'Owner One', 'email' => 'owner1@example.com', 'password' => bcrypt('password'), 'role' => 'owner']);
        $owner2 = User::create(['name' => 'Owner Two', 'email' => 'owner2@example.com', 'password' => bcrypt('password'), 'role' => 'owner']);

        // Owner1 homestays (2)
        $h1 = Homestay::create([
            'owner_id' => $owner1->id,
            'name' => 'H1',
            'description' => 'desc',
            'location' => 'loc',
            'price_per_night' => 100,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        $h2 = Homestay::create([
            'owner_id' => $owner1->id,
            'name' => 'H2',
            'description' => 'desc',
            'location' => 'loc',
            'price_per_night' => 150,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        // Owner2 homestay (1)
        $h3 = Homestay::create([
            'owner_id' => $owner2->id,
            'name' => 'H3',
            'description' => 'desc',
            'location' => 'loc',
            'price_per_night' => 200,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        // Bookings: one booking for h1 and one for h3
        Booking::create(['homestay_id' => $h1->id, 'user_id' => $owner2->id, 'check_in_date' => now()->addDay(), 'check_out_date' => now()->addDays(2), 'total_guests' => 1, 'total_price' => 100, 'status' => 'pending']);
        Booking::create(['homestay_id' => $h3->id, 'user_id' => $owner1->id, 'check_in_date' => now()->addDay(), 'check_out_date' => now()->addDays(2), 'total_guests' => 1, 'total_price' => 200, 'status' => 'pending']);

        // Try using the named route and the literal path to capture any differences
        $responseNamed = $this->actingAs($owner1)->get(route('owner.dashboard'));
        $responsePath = $this->actingAs($owner1)->get('/owner');

        // Prefer path response for clearer debugging
        $this->assertEquals(200, $responsePath->status(), "Response content:\n" . $responsePath->getContent());

        $responsePath->assertViewHas('totalHomestays', 2);
        $responsePath->assertViewHas('totalBookings', 1);
        $responsePath->assertViewHas('pendingBookings', 1);
    }
}
