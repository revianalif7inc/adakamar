<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'paid' to the status enum values (skip on sqlite)
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE `bookings` MODIFY `status` ENUM('pending','paid','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            // Revert to the original enum values (remove 'paid')
            DB::statement("ALTER TABLE `bookings` MODIFY `status` ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending'");
        }
    }
};
