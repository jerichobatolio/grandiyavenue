<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('table_layout_settings')) {
            return;
        }

        Schema::create('table_layout_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('sections_json')->nullable();
            $table->longText('section_order_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_layout_settings');
    }
};
