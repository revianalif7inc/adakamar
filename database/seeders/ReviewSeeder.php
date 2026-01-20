<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Homestay;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $homestays = Homestay::inRandomOrder()->limit(8)->get();

        if ($customers->isEmpty() || $homestays->isEmpty()) {
            $this->command->warn('No customers or homestays found. Skipping ReviewSeeder.');
            return;
        }

        $comments = [
            'Tempatnya bersih dan nyaman, cocok untuk kerja remote.',
            'Pemilik ramah, lokasi strategis dekat kampus.',
            'Harga sesuai fasilitas, recommended!',
            'Kamar agak kecil tapi cukup untuk 1 orang, kebersihan ok.',
            'Pengalaman menginap menyenangkan, fasilitas lengkap.',
            'Suasana tenang, cocok untuk istirahat.',
            'Akses transportasi mudah, dekat warung makan.',
            'Layanan cepat dan responsif, terima kasih.'
        ];

        $created = 0;
        foreach ($homestays as $h) {
            // create 2-3 reviews per homestay from random customers
            $sampleUsers = $customers->shuffle()->take(rand(2, 3));
            foreach ($sampleUsers as $u) {
                $rating = rand(3, 5);
                $comment = $comments[array_rand($comments)];

                Review::updateOrCreate(
                    ['user_id' => $u->id, 'homestay_id' => $h->id],
                    ['rating' => $rating, 'comment' => $comment]
                );

                $created++;
            }

            // recalc average
            $avg = Review::where('homestay_id', $h->id)->avg('rating');
            $h->rating = round((float) $avg, 2);
            $h->save();

            $this->command->info("Updated homestay {$h->id} ({$h->name}) rating to {$h->rating}");
        }

        $this->command->info("Created/updated {$created} reviews for {$homestays->count()} homestays.");
    }
}
