<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure 'Kost' category exists, case-insensitive
        $kost = DB::table('categories')->whereRaw('LOWER(name) = ?', ['kost'])->first();
        if (!$kost) {
            $id = DB::table('categories')->insertGetId([
                'name' => 'Kost',
                'slug' => 'kost',
                'description' => null,
                'sort_order' => 999,
                'is_pinned' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $id = $kost->id;
        }

        // Assign 'Kost' to all homestays that don't already have it
        $homestayIds = DB::table('homestays')->pluck('id');
        $existing = DB::table('homestay_category')->where('category_id', $id)->pluck('homestay_id')->toArray();

        $now = now();
        $inserts = [];
        foreach ($homestayIds as $hid) {
            if (!in_array($hid, $existing)) {
                $inserts[] = [
                    'homestay_id' => $hid,
                    'category_id' => $id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($inserts)) {
            DB::table('homestay_category')->insertOrIgnore($inserts);
        }

        // Also, for older homestays where category_id is null or different, ensure category_id is not left null
        // Set homestays.category_id to Kost if empty
        DB::table('homestays')->whereNull('category_id')->update(['category_id' => $id, 'updated_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove associations and the category only if it matches exactly 'Kost'
        $kost = DB::table('categories')->where('slug', 'kost')->first();
        if ($kost) {
            DB::table('homestay_category')->where('category_id', $kost->id)->delete();
            // Do not delete the category record to avoid data loss unless explicitly desired
        }
    }
};
