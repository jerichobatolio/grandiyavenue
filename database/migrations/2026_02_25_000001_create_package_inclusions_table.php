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
        Schema::create('package_inclusions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "35,000 with decor"
            $table->decimal('price', 10, 2)->default(0);
            $table->text('details')->nullable(); // e.g. "5 main dish, dessert, unlimited rice..."
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_inclusions');
    }
};

