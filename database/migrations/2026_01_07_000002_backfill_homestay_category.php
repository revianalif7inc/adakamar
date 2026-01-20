<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations (backfill pivot table from existing homestays.category_id).
     */
    public function up(): void
    {
        // Ensure pivot table exists
        if (!Schema::hasTable('homestay_category')) {
            return;
        }

        $rows = DB::table('homestays')->whereNotNull('category_id')->pluck('category_id', 'id');

        $now = now();
        $inserts = [];
        foreach ($rows as $homestayId => $categoryId) {
            $inserts[] = [
                'homestay_id' => $homestayId,
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($inserts)) {
            // insertOrIgnore to avoid duplicates
            DB::table('homestay_category')->insertOrIgnore($inserts);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('homestay_category')) {
            return;
        }

        // Remove rows that match homestay -> category mapping in homestays table
        $pairs = DB::table('homestays')->whereNotNull('category_id')->pluck('category_id', 'id');
        foreach ($pairs as $homestayId => $categoryId) {
            DB::table('homestay_category')
                ->where('homestay_id', $homestayId)
                ->where('category_id', $categoryId)
                ->delete();
        }
    }
};
