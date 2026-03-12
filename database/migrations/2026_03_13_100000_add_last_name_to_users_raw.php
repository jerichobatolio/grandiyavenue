<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add last_name to users via raw SQL (works even if migration table is out of sync).
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver !== 'mysql') {
            return;
        }

        $hasColumn = DB::selectOne("
            SELECT COUNT(*) as c FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'users'
            AND COLUMN_NAME = 'last_name'
        ");
        if ((int) $hasColumn->c > 0) {
            return;
        }

        DB::statement('ALTER TABLE users ADD COLUMN last_name VARCHAR(255) NULL AFTER name');
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver !== 'mysql') {
            return;
        }
        $hasColumn = DB::selectOne("
            SELECT COUNT(*) as c FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'users'
            AND COLUMN_NAME = 'last_name'
        ");
        if ((int) $hasColumn->c === 0) {
            return;
        }
        DB::statement('ALTER TABLE users DROP COLUMN last_name');
    }
};
