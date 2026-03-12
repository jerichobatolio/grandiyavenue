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
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('contact_number');
            $table->string('email');
            $table->enum('event_type', ['Birthday', 'Wedding', 'Anniversary', 'Corporate', 'Other']);
            $table->date('event_date');
            $table->integer('number_of_guests');
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['Pending', 'Paid', 'Cancelled'])->default('Pending');
            $table->decimal('down_payment_amount', 10, 2)->default(1500.00);
            $table->string('payment_proof_path')->nullable();
            $table->timestamp('payment_confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_bookings');
    }
};
