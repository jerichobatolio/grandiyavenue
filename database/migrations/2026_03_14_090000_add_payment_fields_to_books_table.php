<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('books')) {
            return;
        }

        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'down_payment_amount')) {
                $table->decimal('down_payment_amount', 10, 2)->default(1000.00)->after('special_requests');
            }
            if (!Schema::hasColumn('books', 'payment_option')) {
                $table->string('payment_option')->nullable()->after('down_payment_amount');
            }
            if (!Schema::hasColumn('books', 'amount_paid')) {
                $table->decimal('amount_paid', 10, 2)->nullable()->after('payment_option');
            }
            if (!Schema::hasColumn('books', 'payment_proof_path')) {
                $table->string('payment_proof_path')->nullable()->after('amount_paid');
            }
            if (!Schema::hasColumn('books', 'payment_confirmed_at')) {
                $table->timestamp('payment_confirmed_at')->nullable()->after('payment_proof_path');
            }
            if (!Schema::hasColumn('books', 'gcash_reference_number')) {
                $table->string('gcash_reference_number')->nullable()->after('payment_confirmed_at');
            }
            if (!Schema::hasColumn('books', 'gcash_transaction_id')) {
                $table->string('gcash_transaction_id')->nullable()->after('gcash_reference_number');
            }
            if (!Schema::hasColumn('books', 'gcash_payment_date')) {
                $table->timestamp('gcash_payment_date')->nullable()->after('gcash_transaction_id');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('books')) {
            return;
        }

        Schema::table('books', function (Blueprint $table) {
            foreach ([
                'gcash_payment_date',
                'gcash_transaction_id',
                'gcash_reference_number',
                'payment_confirmed_at',
                'payment_proof_path',
                'amount_paid',
                'payment_option',
                'down_payment_amount',
            ] as $column) {
                if (Schema::hasColumn('books', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
