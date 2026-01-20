<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Homestay;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HomestayDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_page_displays_gallery_and_inline_booking_form()
    {
        $owner = User::create([
            'name' => 'Owner Test',
            'email' => 'owner-test@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);

        $h = Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Test Homestay',
            'description' => 'Nice place',
            'location' => 'Testville',
            'price_per_night' => 350000,
            'max_guests' => 4,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'image_url' => null,
            'amenities' => ['WiFi', 'AC'],
            'is_active' => true,
        ]);


        // Try both route() and literal path to handle environments where URL generator differs
        $response = $this->get('/kamar/' . $h->id);
        if ($response->status() === 404) {
            $response = $this->get(route('kamar.show', ['id' => $h->id, 'slug' => $h->slug ?? '']));
        }
        $response->assertStatus(200);

        // Booking form and fields
        $response->assertSee('id="inlineBookingForm"', false);
        $response->assertSee('booking_date');
        $response->assertSee('duration');
        $response->assertSee('duration_unit');
        $response->assertSee('total_guests');

        // Price formatting and fallback image placeholder
        $response->assertSee('Rp 350.000');
        $response->assertSee('images/homestays/placeholder.svg');
    }

    public function test_detail_page_shows_multiple_gallery_images()
    {
        Storage::fake('public');

        $owner = User::create([
            'name' => 'Owner Test',
            'email' => 'owner-images@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);

        $h = Homestay::create([
            'owner_id' => $owner->id,
            'name' => 'Gallery Homestay',
            'description' => 'Has multiple images',
            'location' => 'Imageland',
            'price_per_night' => 150000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'image_url' => null,
            'amenities' => ['WiFi'],
            'is_active' => true,
        ]);

        // create fake images and store on public disk
        // Use create() to avoid GD dependency in CI/test environments
        $file1 = UploadedFile::fake()->create('photo1.jpg', 500, 'image/jpeg');
        $file2 = UploadedFile::fake()->create('photo2.jpg', 600, 'image/jpeg');

        $path1 = $file1->store('homestays', 'public');
        $path2 = $file2->store('homestays', 'public');

        $h->images = [$path1, $path2];
        $h->save();

        $response = $this->get('/kamar/' . $h->id);
        if ($response->status() === 404) {
            $response = $this->get(route('kamar.show', ['id' => $h->id, 'slug' => $h->slug ?? '']));
        }

        $response->assertStatus(200);

        // both stored image paths should be referenced in the page
        $response->assertSee('storage/' . $path1);
        $response->assertSee('storage/' . $path2);

        // thumbnails or slider controls should reference both indices
        $response->assertSee('currentSlide(0)');
        $response->assertSee('currentSlide(1)');
    }
}
