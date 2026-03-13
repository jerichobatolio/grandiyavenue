<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('table_statuses')) {
            return;
        }

        Schema::table('table_statuses', function (Blueprint $table) {
            if (!Schema::hasColumn('table_statuses', 'section')) {
                $table->string('section')->nullable()->after('table_number');
            }
            if (!Schema::hasColumn('table_statuses', 'room')) {
                $table->unsignedInteger('room')->nullable()->after('section');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('table_statuses')) {
            return;
        }

        Schema::table('table_statuses', function (Blueprint $table) {
            if (Schema::hasColumn('table_statuses', 'room')) {
                $table->dropColumn('room');
            }
            if (Schema::hasColumn('table_statuses', 'section')) {
                $table->dropColumn('section');
            }
        });
    }
};
