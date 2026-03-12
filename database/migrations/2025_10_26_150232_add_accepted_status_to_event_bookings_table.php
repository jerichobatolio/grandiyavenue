<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the status enum to add 'Accepted' status and remove 'Completed'
        DB::statement("ALTER TABLE event_bookings MODIFY COLUMN status ENUM('Pending', 'Accepted', 'Confirmed', 'Paid', 'Cancelled') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous status enum
        DB::statement("ALTER TABLE event_bookings MODIFY COLUMN status ENUM('Pending', 'Confirmed', 'Paid', 'Cancelled', 'Completed') DEFAULT 'Pending'");
    }
};
