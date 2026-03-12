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
        Schema::create('return_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Polymorphic relationship for EventBooking or Order
            $table->morphs('refundable'); // Creates refundable_id and refundable_type
            
            $table->enum('type', ['return', 'refund'])->default('refund');
            $table->enum('status', ['pending', 'approved', 'rejected', 'refunded', 'cancelled'])->default('pending');
            
            $table->decimal('refund_amount', 10, 2);
            $table->text('reason');
            $table->text('admin_notes')->nullable();
            
            // Refund processing details
            $table->timestamp('processed_at')->nullable();
            $table->string('refund_method')->nullable(); // GCash, Bank Transfer, etc.
            $table->string('refund_reference')->nullable(); // Transaction reference
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_refunds');
    }
};
