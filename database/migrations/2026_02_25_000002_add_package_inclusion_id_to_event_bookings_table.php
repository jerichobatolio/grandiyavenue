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
            $table->unsignedBigInteger('package_inclusion_id')->nullable()->after('venue_type_id');
            $table->foreign('package_inclusion_id')->references('id')->on('package_inclusions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropForeign(['package_inclusion_id']);
            $table->dropColumn('package_inclusion_id');
        });
    }
};
