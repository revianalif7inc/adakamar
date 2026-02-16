<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('str_before')) {
    function str_before($subject, $search)
    {
        $pos = strpos($subject, $search);
        return $pos === false ? $subject : substr($subject, 0, $pos);
    }
}

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // add slug to bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
        });

        // backfill homestays that may be missing slugs
        try {
            $homestays = DB::table('homestays')->select('id', 'name', 'slug')->get();
            foreach ($homestays as $h) {
                if (empty($h->slug) && !empty($h->name)) {
                    $base = Str::slug($h->name);
                    $slug = $base;
                    $i = 1;
                    while (DB::table('homestays')->where('slug', $slug)->exists()) {
                        $slug = $base . '-' . $i++;
                    }
                    DB::table('homestays')->where('id', $h->id)->update(['slug' => $slug]);
                }
            }
        } catch (\Throwable $e) {
            // ignore in case table not present or other issues
        }

        // backfill bookings with unique slugs
        try {
            $bookings = DB::table('bookings')->select('id', 'nama', 'email')->get();
            foreach ($bookings as $b) {
                // build slug from name/email + id for uniqueness
                $base = 'booking-' . $b->id;
                if (!empty($b->nama)) {
                    $base = Str::slug($b->nama) . '-' . $b->id;
                } elseif (!empty($b->email)) {
                    $base = Str::slug(str_before($b->email, '@')) . '-' . $b->id;
                }
                $slug = $base;
                $i = 1;
                while (DB::table('bookings')->where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                DB::table('bookings')->where('id', $b->id)->update(['slug' => $slug]);
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'slug')) {
                // drop unique index first (if exists)
                try {
                    $table->dropUnique(['slug']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('slug');
            }
        });
    }
};
