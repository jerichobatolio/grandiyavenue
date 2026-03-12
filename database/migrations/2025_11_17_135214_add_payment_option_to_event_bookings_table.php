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
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->enum('payment_option', ['down_payment', 'full_payment'])
                ->nullable()
                ->after('down_payment_amount');
            $table->decimal('amount_paid', 10, 2)
                ->nullable()
                ->after('payment_option');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn(['amount_paid', 'payment_option']);
        });
    }
};
