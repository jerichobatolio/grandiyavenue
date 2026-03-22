<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Gallery update form did not send is_active, so Laravel set is_active = false
     * on every save — public "Our Menu" only shows active items, so menus disappeared.
     */
    public function up(): void
    {
        if (! Schema::hasTable('galleries')) {
            return;
        }

        DB::table('galleries')->update(['is_active' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
