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
            $table->string('name', 100);
            $table->integer('duration');
            $table->tinyInteger('min_players');
            $table->tinyInteger('max_players');
            $table->tinyInteger('min_age');
            $table->string('url', 255);
            $table->datetime('active_from');
            $table->datetime('active_until')->nullable();
            $table->integer('max_booking_advance')->nullable();
            $table->string('color', 7)->nullable(); 
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
