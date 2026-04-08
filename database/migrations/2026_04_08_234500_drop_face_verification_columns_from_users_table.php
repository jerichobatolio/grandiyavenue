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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'face_verification_path')) {
                $table->dropColumn('face_verification_path');
            }

            if (Schema::hasColumn('users', 'face_verified_at')) {
                $table->dropColumn('face_verified_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'face_verification_path')) {
                $table->string('face_verification_path')->nullable()->after('email_otp_verified_at');
            }

            if (! Schema::hasColumn('users', 'face_verified_at')) {
                $table->timestamp('face_verified_at')->nullable()->after('face_verification_path');
            }
        });
    }
};
