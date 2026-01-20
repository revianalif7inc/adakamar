<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('homestays', function (Blueprint $table) {
            if (!Schema::hasColumn('homestays', 'images')) {
                $table->json('images')->nullable()->after('image_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homestays', function (Blueprint $table) {
            if (Schema::hasColumn('homestays', 'images')) {
                $table->dropColumn('images');
            }
        });
    }
};
