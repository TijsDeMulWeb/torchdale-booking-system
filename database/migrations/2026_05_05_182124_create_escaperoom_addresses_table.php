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
        Schema::create('escaperoom_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');
            $table->string('street', 255);
            $table->string('street_number', 10)->nullable();
            $table->string('postal_code', 10);
            $table->string('city', 100);
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escaperoom_addresses');
    }
};
