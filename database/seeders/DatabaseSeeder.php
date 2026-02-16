<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Homestay;
use App\Models\Category;
use App\Models\Location;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin AdaKamar',
            'email' => 'admin@adakamar.id',
            'password' => Hash::make('password123'),
            'phone' => '0812345678',
            'role' => 'admin',
        ]);

        // Create Sample Owners
        $owner1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'owner1@adakamar.id',
            'password' => Hash::make('password123'),
            'phone' => '0898765432',
            'role' => 'owner',
        ]);

        $owner2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'owner2@adakamar.id',
            'password' => Hash::make('password123'),
            'phone' => '0899876543',
            'role' => 'owner',
        ]);

        // Create Sample Customers
        $customer1 = User::create([
            'name' => 'Rudi Hartanto',
            'email' => 'rudi@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '0811223344',
            'role' => 'customer',
        ]);

        $customer2 = User::create([
            'name' => 'Ani Wijaya',
            'email' => 'ani@gmail.com',
            'password' => Hash::make('password123'),
            'phone' => '0812334455',
            'role' => 'customer',
        ]);

        $customer3 = User::create([
            'name' => 'Bambang Suryanto',
            'email' => 'bambang@yahoo.com',
            'password' => Hash::make('password123'),
            'phone' => '0813445566',
            'role' => 'customer',
        ]);

        // Create Locations
        $loc_yogya = Location::create([
            'name' => 'Yogyakarta',
            'slug' => 'yogyakarta',
            'description' => 'Kota istimewa dengan budaya dan wisata yang kaya di Jawa Tengah.',
        ]);

        $loc_bandung = Location::create([
            'name' => 'Bandung',
            'slug' => 'bandung',
            'description' => 'Kota kembang dengan suasana sejuk dan destinasi wisata menarik.',
        ]);

        $loc_bali = Location::create([
            'name' => 'Bali',
            'slug' => 'bali',
            'description' => 'Pulau dewata dengan keindahan alam dan pantai yang memukau.',
        ]);

        $loc_jakarta = Location::create([
            'name' => 'Jakarta',
            'slug' => 'jakarta',
            'description' => 'Ibu kota Indonesia dengan berbagai pilihan akomodasi modern.',
        ]);

        // Create Categories (sesuaikan dengan migration yang sudah ada)
        // 'Kost' sudah dibuat oleh migration, jadi cari atau ambil yang ada
        $cat_kost = Category::firstOrCreate(
            ['slug' => 'kost'],
            [
                'name' => 'Kost',
                'description' => 'Kamar kost yang terjangkau dengan fasilitas lengkap.',
                'sort_order' => 1,
                'is_pinned' => true,
            ]
        );

        $cat_villa = Category::firstOrCreate(
            ['slug' => 'villa'],
            [
                'name' => 'Villa',
                'description' => 'Villa mewah untuk liburan keluarga dan rombongan.',
                'sort_order' => 2,
                'is_pinned' => true,
            ]
        );

        $cat_apartment = Category::firstOrCreate(
            ['slug' => 'apartment'],
            [
                'name' => 'Apartment',
                'description' => 'Apartemen modern dengan lokasi strategis di kota besar.',
                'sort_order' => 3,
                'is_pinned' => false,
            ]
        );

        $cat_guest = Category::firstOrCreate(
            ['slug' => 'guest-house'],
            [
                'name' => 'Guest House',
                'description' => 'Guest house nyaman untuk tamu yang ingin pengalaman lokal.',
                'sort_order' => 4,
                'is_pinned' => false,
            ]
        );

        // Create Homestays with multiple pricing options
        $h1 = Homestay::create([
            'owner_id' => $owner1->id,
            'location_id' => $loc_yogya->id,
            'name' => 'Villa Malioboro Elegance',
            'slug' => 'villa-malioboro-elegance',
            'description' => 'Villa mewah di pusat Yogyakarta dengan pemandangan yang indah, dilengkapi dengan kolam renang pribadi dan taman yang asri. Cocok untuk liburan keluarga atau acara spesial.',
            'location' => 'Jl. Malioboro, Yogyakarta',
            'price_per_night' => 350000,
            'price_per_month' => 8000000,
            'price_per_year' => 80000000,
            'max_guests' => 6,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'image_url' => null,
            'images' => [],
            'amenities' => ['WiFi', 'AC', 'Dapur Lengkap', 'Parkir Gratis', 'TV Smart', 'Kolam Renang', 'Taman', 'Ruang Keluarga'],
            'rating' => 4.5,
            'is_active' => true,
            'is_featured' => true,
        ]);
        $h1->categories()->attach($cat_villa->id);

        // Additional Yogyakarta homestays for slider
        $h1b = Homestay::create([
            'owner_id' => $owner1->id,
            'location_id' => $loc_yogya->id,
            'name' => 'Kost Taman Sari Jogja',
            'slug' => 'kost-taman-sari-jogja',
            'description' => 'Kost nyaman dekat dengan universitas dan pusat belanja. Ideal untuk mahasiswa dan karyawan muda dengan fasilitas terlengkap.',
            'location' => 'Jl. Taman Sari, Yogyakarta',
            'price_per_night' => 150000,
            'price_per_month' => 2500000,
            'price_per_year' => 25000000,
            'max_guests' => 2,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'image_url' => null,
            'images' => [],
            'amenities' => ['WiFi', 'AC', 'Keamanan 24 Jam', 'Dapur Bersama'],
            'rating' => 4.6,
            'is_active' => true,
            'is_featured' => false,
        ]);
        $h1b->categories()->attach($cat_kost->id);

        $h1c = Homestay::create([
            'owner_id' => $owner2->id,
            'location_id' => $loc_yogya->id,
            'name' => 'Rumah Jogja Heritage',
            'slug' => 'rumah-jogja-heritage',
            'description' => 'Rumah tradisional Jogja yang didesain ulang modern. Sempurna untuk keluarga yang menghargai budaya lokal dengan kenyamanan modern.',
            'location' => 'Jl. Ketandan, Yogyakarta',
            'price_per_night' => 400000,
            'price_per_month' => 8000000,
            'price_per_year' => 80000000,
            'max_guests' => 8,
            'bedrooms' => 4,
            'bathrooms' => 3,
            'image_url' => null,
            'images' => [],
            'amenities' => ['WiFi', 'Taman', 'Dapur Lengkap', 'Parkir', 'Ruang Keluarga', 'AC'],
            'rating' => 4.7,
            'is_active' => true,
            'is_featured' => false,
        ]);
        $h1c->categories()->attach($cat_villa->id);

        $h1d = Homestay::create([
            'owner_id' => $owner2->id,
            'location_id' => $loc_yogya->id,
            'name' => 'Apartemen Malioboro Plaza',
            'slug' => 'apartemen-malioboro-plaza',
            'description' => 'Apartemen modern di pusat Malioboro. Lokasi strategis dengan akses mudah ke belanja dan hiburan untuk bisnis atau liburan.',
            'location' => 'Jl. Malioboro, Yogyakarta',
            'price_per_night' => 250000,
            'price_per_month' => 5000000,
            'price_per_year' => 50000000,
            'max_guests' => 4,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'image_url' => null,
            'images' => [],
            'amenities' => ['WiFi', 'AC', 'Lift', 'Keamanan', 'Parkir Tertutup'],
            'rating' => 4.5,
            'is_active' => true,
            'is_featured' => false,
        ]);
        $h1d->categories()->attach($cat_apartment->id);

        $h2 = Homestay::create([
            'owner_id' => $owner1->id,
            'location_id' => $loc_bandung->id,
            'name' => 'Kost Braga Minimalis',
            'slug' => 'kost-braga-minimalis',
            'description' => 'Kost modern dengan interior minimalis, lokasi strategis dekat dengan pusat kota Bandung. Fasilitas lengkap dengan harga yang terjangkau untuk pelajar dan pekerja muda.',
            'location' => 'Jl. Braga, Bandung',
            'price_per_night' => 150000,
            'price_per_month' => 3500000,
            'price_per_year' => 35000000,
            'max_guests' => 4,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'image_url' => null,
            'images' => [],
            'amenities' => ['WiFi', 'AC', 'Kamar Mandi Pribadi', 'Dapur Bersama', 'Area Parkir', 'Ruang Bersama'],
            'rating' => 4.0,
            'is_active' => true,
            'is_featured' => true,
        ]);
        $h2->categories()->attach($cat_kost->id);

        $h3 = Homestay::create([
            'owner_id' => $owner2->id,
            'location_id' => $loc_bali->id,
            'name' => 'Bali Beach House Paradise',
            'slug' => 'bali-beach-house-paradise',
            'description' => 'Rumah tepi pantai di Bali dengan pemandangan laut yang menakjubkan. Dilengkapi dengan fasilitas premium termasuk kolam renang pribadi, spa, dan akses langsung ke pantai berpasir putih.',
            'location' => 'Jl. Pantai Kuta, Bali',
            'price_per_night' => 500000,
            'price_per_month' => 12000000,
            'price_per_year' => 120000000,
            'max_guests' => 8,
            'bedrooms' => 4,
            'bathrooms' => 3,
            'image_url' => null,
            'images' => [],
            'amenities' => ['WiFi', 'AC', 'Kolam Renang Pribadi', 'Pantai Pribadi', 'Dapur Lengkap', 'Gym', 'Spa', 'Home Theatre', 'Concierge 24/7'],
            'rating' => 5.0,
            'is_active' => true,
            'is_featured' => true,
        ]);
        $h3->categories()->attach($cat_villa->id);

        $h4 = Homestay::create([
            'owner_id' => $owner2->id,
            'location_id' => $loc_jakarta->id,
            'name' => 'Apartemen Pusat Jakarta',
            'slug' => 'apartemen-pusat-jakarta',
            'description' => 'Apartemen modern di pusat bisnis Jakarta dengan lokasi strategis. Dekat dengan stasiun MRT, mal, dan area bisnis. Cocok untuk bisnis trip dan liburan keluarga.',
            'location' => 'Jl. Sudirman, Jakarta',
            'price_per_night' => 250000,
            'price_per_month' => 6000000,
            'price_per_year' => 60000000,
            'max_guests' => 4,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'image_url' => null,
            'images' => [],
            'amenities' => ['WiFi', 'AC', 'Lift', 'Keamanan 24/7', 'Dapur Lengkap', 'Mesin Cuci', 'Gym', 'Teras'],
            'rating' => 4.2,
            'is_active' => true,
            'is_featured' => false,
        ]);
        $h4->categories()->attach($cat_apartment->id);

        // Create Bookings with personal info
        Booking::create([
            'user_id' => $customer1->id,
            'homestay_id' => $h1->id,
            'check_in_date' => Carbon::now()->addDays(7),
            'check_out_date' => Carbon::now()->addDays(14),
            'total_guests' => 4,
            'total_price' => 2450000,
            'status' => 'confirmed',
            'special_requests' => 'Mohon siapkan welcome drink dan bunga di kamar.',
            'nama' => 'Rudi Hartanto',
            'email' => 'rudi@gmail.com',
            'nomor_hp' => '0811223344',
        ]);

        Booking::create([
            'user_id' => $customer2->id,
            'homestay_id' => $h2->id,
            'check_in_date' => Carbon::now()->subDays(5),
            'check_out_date' => Carbon::now()->addDays(25),
            'total_guests' => 2,
            'total_price' => 7000000,
            'status' => 'confirmed',
            'special_requests' => 'Butuh tempat yang quiet untuk bekerja.',
            'nama' => 'Ani Wijaya',
            'email' => 'ani@gmail.com',
            'nomor_hp' => '0812334455',
        ]);

        Booking::create([
            'user_id' => $customer3->id,
            'homestay_id' => $h3->id,
            'check_in_date' => Carbon::now()->addDays(15),
            'check_out_date' => Carbon::now()->addDays(20),
            'total_guests' => 6,
            'total_price' => 2500000,
            'status' => 'pending',
            'special_requests' => 'Pesan untuk rombongan keluarga, butuh private chef jika memungkinkan.',
            'nama' => 'Bambang Suryanto',
            'email' => 'bambang@yahoo.com',
            'nomor_hp' => '0813445566',
        ]);

        // Create Reviews
        Review::create([
            'user_id' => $customer1->id,
            'homestay_id' => $h1->id,
            'rating' => 5,
            'comment' => 'Pelayanan sangat memuaskan, fasilitas lengkap, dan owner-nya sangat ramah. Lokasi yang strategis di Malioboro. Pasti akan booking lagi!',
        ]);

        Review::create([
            'user_id' => $customer2->id,
            'homestay_id' => $h2->id,
            'rating' => 4,
            'comment' => 'Kost yang bagus dengan harga terjangkau. WiFi cepat dan lokasi dekat dengan berbagai tempat. Staff yang helpful.',
        ]);

        Review::create([
            'user_id' => $customer1->id,
            'homestay_id' => $h3->id,
            'rating' => 5,
            'comment' => 'Pengalaman menginap yang tak terlupakan. Pemandangan pantai yang spektakuler, fasilitas world-class. Highly recommended!',
        ]);

        // Seed articles
        $this->call(\Database\Seeders\ArticleSeeder::class);
    }
}
