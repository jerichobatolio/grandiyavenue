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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('title')->nullable()->after('type');
            $table->unsignedBigInteger('event_booking_id')->nullable()->after('order_id');
            $table->foreign('event_booking_id')->references('id')->on('event_bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['event_booking_id']);
            $table->dropColumn(['title', 'event_booking_id']);
        });
    }
};
