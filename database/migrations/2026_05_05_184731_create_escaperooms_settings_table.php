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
        Schema::create('escaperoom_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');
            $table->text('mollie_api_key')->nullable();
            $table->text('openai_api_key')->nullable();
            $table->string('widget_color_primary', 7)->default('#ed6e0c');
            $table->string('widget_color_primary_dark', 7)->default('#b8560a');
            $table->string('widget_color_background_dark', 7)->default('#1f2445');
            $table->string('widget_color_text', 7)->default('#1f2445');
            $table->string('widget_color_sale', 7)->default('#e74c3c');
            $table->string('widget_color_success', 7)->default('#27ae60');
            $table->string('confirmation_room_url')->nullable();
            $table->string('confirmation_product_url')->nullable();
            $table->string('confirmation_gift_card_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escaperoom_settings');
    }
};
