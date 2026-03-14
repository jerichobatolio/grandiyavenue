<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Book extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'phone',
        'guest', 
        'date',
        'time',
        'status',
        'table_number',
        'table_section',
        'time_in',
        'time_out',
        'duration_hours',
        'occasion',
        'special_requests',
        'down_payment_amount',
        'payment_option',
        'amount_paid',
        'payment_proof_path',
        'payment_confirmed_at',
        'gcash_reference_number',
        'gcash_transaction_id',
        'gcash_payment_date',
        'user_id',
        'is_archived'
    ];
    
    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
        'down_payment_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'payment_confirmed_at' => 'datetime',
        'gcash_payment_date' => 'datetime',
    ];

    public static function ensurePaymentColumnsExist(): void
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
}
