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
            $table->unsignedBigInteger('venue_type_id')->nullable()->after('event_type_id');
            $table->foreign('venue_type_id')->references('id')->on('venue_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropForeign(['venue_type_id']);
            $table->dropColumn('venue_type_id');
        });
    }
};
