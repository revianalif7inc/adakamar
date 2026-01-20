<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('homestays', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Backfill slug values for existing records (generate unique slugs)
        if (Schema::hasTable('homestays')) {
            $homestays = DB::table('homestays')->whereNull('slug')->get();
            foreach ($homestays as $h) {
                $base = Str::slug($h->name ?: ('homestay-' . $h->id));
                $slug = $base;
                $i = 1;
                while (DB::table('homestays')->where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i;
                    $i++;
                }
                DB::table('homestays')->where('id', $h->id)->update(['slug' => $slug]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homestays', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
