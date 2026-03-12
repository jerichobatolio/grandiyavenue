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
        Schema::table('package_inclusions', function (Blueprint $table) {
            $table->unsignedInteger('pax_min')->nullable()->after('name');
            $table->unsignedInteger('pax_max')->nullable()->after('pax_min');
        });
        Schema::table('package_inclusions', function (Blueprint $table) {
            $table->dropColumn('pax');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_inclusions', function (Blueprint $table) {
            $table->unsignedInteger('pax')->nullable()->after('name');
        });
        Schema::table('package_inclusions', function (Blueprint $table) {
            $table->dropColumn(['pax_min', 'pax_max']);
        });
    }
};
