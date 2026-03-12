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
        Schema::table('announcements', function (Blueprint $table) {
            if (!Schema::hasColumn('announcements', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('announcements', 'content')) {
                $table->text('content')->after('title');
            }
            if (!Schema::hasColumn('announcements', 'image')) {
                $table->string('image')->nullable()->after('content');
            }
            if (!Schema::hasColumn('announcements', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('image');
            }
            if (!Schema::hasColumn('announcements', 'start_date')) {
                $table->dateTime('start_date')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('announcements', 'end_date')) {
                $table->dateTime('end_date')->nullable()->after('start_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (Schema::hasColumn('announcements', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('announcements', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('announcements', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('announcements', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('announcements', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('announcements', 'end_date')) {
                $table->dropColumn('end_date');
            }
        });
    }
};
