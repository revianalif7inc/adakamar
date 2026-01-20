<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run direct ALTER for drivers that support it (skip sqlite in testing)
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE `homestays` MODIFY `price_per_night` DECIMAL(10,2) NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE `homestays` MODIFY `price_per_night` DECIMAL(10,2) NOT NULL');
        }
    }
};
