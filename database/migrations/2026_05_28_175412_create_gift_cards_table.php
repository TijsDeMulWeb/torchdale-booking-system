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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('name', 100);
            $table->string('description')->nullable();
            $table->string('code', 50);
            $table->decimal('amount', 10, 2);
            $table->string('recipient_first_name', 75)->nullable();
            $table->string('recipient_last_name', 75)->nullable();
            $table->string('recipient_email', 255)->nullable();
            $table->string('recipient_phone', 20)->nullable();
            $table->string('method', 50);
            $table->string('status', 50);
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('redeemed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
};
