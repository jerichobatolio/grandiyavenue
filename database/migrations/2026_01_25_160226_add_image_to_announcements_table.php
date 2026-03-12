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
        // Image column already added in create_announcements_table migration
        // This migration is kept for backward compatibility
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed
    }
};
