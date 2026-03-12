<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('books', 'table_number')) {
                $table->string('table_number')->nullable()->after('time');
            }
            if (!Schema::hasColumn('books', 'status')) {
                $table->string('status')->default('pending')->after('table_number');
            }
            if (!Schema::hasColumn('books', 'time_in')) {
                $table->dateTime('time_in')->nullable()->after('time');
            }
            if (!Schema::hasColumn('books', 'time_out')) {
                $table->dateTime('time_out')->nullable()->after('time_in');
            }
            if (!Schema::hasColumn('books', 'duration_hours')) {
                $table->unsignedInteger('duration_hours')->nullable()->after('time_out');
            }
            if (!Schema::hasColumn('books', 'occasion')) {
                $table->string('occasion')->nullable()->after('status');
            }
            if (!Schema::hasColumn('books', 'special_requests')) {
                $table->text('special_requests')->nullable()->after('occasion');
            }
            if (!Schema::hasColumn('books', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('special_requests');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('books', 'table_number')) {
                $table->dropColumn('table_number');
            }
            if (Schema::hasColumn('books', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('books', 'time_in')) {
                $table->dropColumn('time_in');
            }
            if (Schema::hasColumn('books', 'time_out')) {
                $table->dropColumn('time_out');
            }
            if (Schema::hasColumn('books', 'duration_hours')) {
                $table->dropColumn('duration_hours');
            }
            if (Schema::hasColumn('books', 'occasion')) {
                $table->dropColumn('occasion');
            }
            if (Schema::hasColumn('books', 'special_requests')) {
                $table->dropColumn('special_requests');
            }
            if (Schema::hasColumn('books', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};


