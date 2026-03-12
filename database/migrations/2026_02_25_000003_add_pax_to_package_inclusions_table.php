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
            $table->unsignedInteger('pax')->nullable()->after('name'); // number of persons
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_inclusions', function (Blueprint $table) {
            $table->dropColumn('pax');
        });
    }
};
