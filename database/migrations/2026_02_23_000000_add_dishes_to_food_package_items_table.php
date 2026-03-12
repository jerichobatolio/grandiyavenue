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
        if (Schema::hasTable('food_package_items')) {
            Schema::table('food_package_items', function (Blueprint $table) {
                if (!Schema::hasColumn('food_package_items', 'dishes')) {
                    $table->text('dishes')->nullable()->after('name');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('food_package_items') && Schema::hasColumn('food_package_items', 'dishes')) {
            Schema::table('food_package_items', function (Blueprint $table) {
                $table->dropColumn('dishes');
            });
        }
    }
};

