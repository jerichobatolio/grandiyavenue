<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            // Remove the old event_type ENUM column since we now use event_type_id foreign key
            $table->dropColumn('event_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            // Restore the old event_type ENUM column
            $table->enum('event_type', ['Birthday', 'Wedding', 'Anniversary', 'Corporate', 'Other'])->after('email');
        });
    }
};