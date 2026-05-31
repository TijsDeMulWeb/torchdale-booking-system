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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');
            $table->string('first_name', 75);
            $table->string('last_name', 75);
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();
            $table->string('street', 255);
            $table->string('house_number', 20);
            $table->string('postal_code', 20);
            $table->string('city', 100);
            $table->string('country', 100);
            $table->dateTime('banned_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
