<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');
            $table->foreignId('escaperoom_address_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('duration');
            $table->string('min_players');
            $table->string('max_players');
            $table->string('min_age');
            $table->string('url');
            $table->string('active_from');
            $table->string('active_until')->nullable();
            $table->string('max_booking_advance')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
