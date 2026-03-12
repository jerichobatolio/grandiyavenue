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
            // Add GCash-specific fields
            $table->string('gcash_reference_number')->nullable();
            $table->string('gcash_transaction_id')->nullable();
            $table->timestamp('gcash_payment_date')->nullable();
            
            // Update status enum to include more statuses
            $table->dropColumn('status');
        });
        
        // Add the updated status column
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Confirmed', 'Paid', 'Cancelled', 'Completed'])->default('Pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn(['gcash_reference_number', 'gcash_transaction_id', 'gcash_payment_date']);
            $table->dropColumn('status');
        });
        
        // Restore original status column
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Paid', 'Cancelled'])->default('Pending');
        });
    }
};