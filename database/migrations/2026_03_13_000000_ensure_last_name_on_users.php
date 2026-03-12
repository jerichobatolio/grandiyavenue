<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ensure users table has last_name (fix production missing column).
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'last_name')) {
            return;
        }
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('users', 'last_name')) {
            return;
        }
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
        });
    }
};
