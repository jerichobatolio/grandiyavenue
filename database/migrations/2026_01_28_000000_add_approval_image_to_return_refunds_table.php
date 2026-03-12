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
        Schema::table('return_refunds', function (Blueprint $table) {
            $table->string('approval_image_path')->nullable()->after('admin_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_refunds', function (Blueprint $table) {
            $table->dropColumn('approval_image_path');
        });
    }
};

