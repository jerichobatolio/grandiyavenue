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
        Schema::create('event_type_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_type_id')->constrained('event_types')->cascadeOnDelete();
            $table->string('label', 100); // e.g. AM, PM, Whole Day
            $table->time('start_time')->nullable(); // null for Whole Day
            $table->time('end_time')->nullable();   // null for Whole Day
            $table->text('details')->nullable();   // e.g. "1-3 hours can be extended"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_type_time_slots');
    }
};
