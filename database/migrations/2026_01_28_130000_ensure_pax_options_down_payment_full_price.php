<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds down_payment and full_price to pax_options if missing
     * (e.g. earlier migration ran with empty body).
     */
    public function up(): void
    {
        Schema::table('pax_options', function (Blueprint $table) {
            if (!Schema::hasColumn('pax_options', 'down_payment')) {
                $table->decimal('down_payment', 10, 2)->default(0)->after('value');
            }
            if (!Schema::hasColumn('pax_options', 'full_price')) {
                $table->decimal('full_price', 10, 2)->default(0)->after('down_payment');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pax_options', function (Blueprint $table) {
            if (Schema::hasColumn('pax_options', 'down_payment')) {
                $table->dropColumn('down_payment');
            }
            if (Schema::hasColumn('pax_options', 'full_price')) {
                $table->dropColumn('full_price');
            }
        });
    }
};
