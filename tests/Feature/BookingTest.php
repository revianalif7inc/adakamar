<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Homestay;
use App\Models\Booking;
use Carbon\Carbon;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_monthly_booking_success()
    {
        $owner = User::create(['name' => 'Owner', 'email' => 'owner@example.com', 'password' => bcrypt('password'), 'role' => 'owner']);

        $h = Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Kost Monthly',
            'description' => 'desc',
            'location' => 'loc',
            'price_per_night' => 100000,
            'price_per_month' => 1000000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        $user = User::create(['name' => 'User', 'email' => 'user@example.com', 'password' => bcrypt('password'), 'role' => 'customer']);

        $bookingDate = Carbon::now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($user)->post(route('booking.store'), [
            'homestay_id' => $h->id,
            'booking_date' => $bookingDate,
            'duration' => 2,
            'duration_unit' => 'month',
            'total_guests' => 1,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'homestay_id' => $h->id,
            'user_id' => $user->id,
            'total_price' => 2000000,
        ]);

        $booking = Booking::first();
        $this->assertDatabaseHas('bookings', [
            'homestay_id' => $h->id,
            'check_out_date' => Carbon::parse($bookingDate)->addMonthsNoOverflow(2)->toDateTimeString(),
        ]);
    }

    public function test_yearly_booking_success()
    {
        $owner = User::create(['name' => 'Owner2', 'email' => 'owner2@example.com', 'password' => bcrypt('password'), 'role' => 'owner']);

        $h = Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Sewa Tahunan',
            'description' => 'desc',
            'location' => 'loc',
            'price_per_night' => 100000,
            'price_per_year' => 12000000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        $user = User::create(['name' => 'User2', 'email' => 'user2@example.com', 'password' => bcrypt('password'), 'role' => 'customer']);

        $bookingDate = Carbon::now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($user)->post(route('booking.store'), [
            'homestay_id' => $h->id,
            'booking_date' => $bookingDate,
            'duration' => 1,
            'duration_unit' => 'year',
            'total_guests' => 1,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'homestay_id' => $h->id,
            'user_id' => $user->id,
            'total_price' => 12000000,
        ]);

        $this->assertDatabaseHas('bookings', [
            'homestay_id' => $h->id,
            'check_out_date' => Carbon::parse($bookingDate)->addYears(1)->toDateTimeString(),
        ]);
    }

    public function test_booking_fails_when_price_not_set_for_unit()
    {
        $owner = User::create(['name' => 'Owner3', 'email' => 'owner3@example.com', 'password' => bcrypt('password'), 'role' => 'owner']);

        $h = Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'No Monthly Price',
            'description' => 'desc',
            'location' => 'loc',
            'price_per_night' => 100000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'is_active' => true,
        ]);

        $user = User::create(['name' => 'User3', 'email' => 'user3@example.com', 'password' => bcrypt('password'), 'role' => 'customer']);

        $bookingDate = Carbon::now()->addDay()->format('Y-m-d');

        $response = $this->actingAs($user)->post(route('booking.store'), [
            'homestay_id' => $h->id,
            'booking_date' => $bookingDate,
            'duration' => 1,
            'duration_unit' => 'month',
            'total_guests' => 1,
        ]);

        $response->assertSessionHasErrors('duration');
        $this->assertDatabaseCount('bookings', 0);
    }
}
