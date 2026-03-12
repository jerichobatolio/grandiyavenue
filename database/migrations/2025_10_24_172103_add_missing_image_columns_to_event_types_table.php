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
        Schema::table('event_types', function (Blueprint $table) {
            // Add the missing columns that the model expects
            $table->string('qr_code_image')->nullable()->after('price');
            $table->string('admin_photo')->nullable()->after('qr_code_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_types', function (Blueprint $table) {
            $table->dropColumn(['qr_code_image', 'admin_photo']);
        });
    }
};
