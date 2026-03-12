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
        Schema::table('books', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('time');
            $table->string('table_number')->nullable()->after('status');
            $table->string('time_in')->nullable()->after('table_number');
            $table->string('time_out')->nullable()->after('time_in');
            $table->string('duration_hours')->nullable()->after('time_out');
            $table->string('occasion')->nullable()->after('duration_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['status', 'table_number', 'time_in', 'time_out', 'duration_hours', 'occasion']);
        });
    }
};
