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
        // Make status column nullable and remove default value
        DB::statement('ALTER TABLE books MODIFY COLUMN status VARCHAR(255) NULL DEFAULT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore status column with default value
        DB::statement("ALTER TABLE books MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'pending'");
    }
};

