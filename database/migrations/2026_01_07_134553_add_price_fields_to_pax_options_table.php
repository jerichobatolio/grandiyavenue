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
        Schema::table('pax_options', function (Blueprint $table) {
            // Add pricing fields so each pax option can define
            // its own down payment and full payment amounts.
            $table->decimal('down_payment', 10, 2)->default(0)->after('value');
            $table->decimal('full_price', 10, 2)->default(0)->after('down_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pax_options', function (Blueprint $table) {
            $table->dropColumn(['down_payment', 'full_price']);
        });
    }
};
