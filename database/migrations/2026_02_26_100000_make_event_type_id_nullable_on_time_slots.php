<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_type_time_slots', function (Blueprint $table) {
            $table->dropForeign(['event_type_id']);
            $table->unsignedBigInteger('event_type_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('event_type_time_slots', function (Blueprint $table) {
            $table->unsignedBigInteger('event_type_id')->nullable(false)->change();
            $table->foreign('event_type_id')->references('id')->on('event_types')->cascadeOnDelete();
        });
    }
};
