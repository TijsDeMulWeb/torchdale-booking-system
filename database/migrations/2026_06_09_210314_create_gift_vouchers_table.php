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
        Schema::create('gift_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');

            // Unieke 4x4-cijferige code, bv. 1234-5678-9012-3456
            $table->string('code', 19)->unique();

            $table->decimal('amount', 10, 2);

            // Wie ontvangt de bon
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');

            // Bron: welke order heeft de bon aangemaakt
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            // Als gekocht via een giftcard-product
            $table->foreignId('gift_card_id')->nullable()->constrained('gift_cards')->onDelete('set null');

            // 'purchase' = gekocht als product, 'cancellation' = bon als vergoeding bij annulering
            $table->string('source', 20)->default('purchase');

            // Status: active | used | expired
            $table->string('status', 20)->default('active');

            $table->dateTime('valid_until')->nullable();

            // Wanneer gebruikt en bij welke order ingelost
            $table->dateTime('used_at')->nullable();
            $table->foreignId('used_order_id')->nullable()->constrained('orders')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_vouchers');
    }
};
