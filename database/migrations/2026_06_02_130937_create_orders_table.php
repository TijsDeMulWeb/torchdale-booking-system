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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->string('mollie_id')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('vat_rate', 10, 2)->nullable();
            $table->decimal('vat_amount', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->string('status', 50)->default('pending');
            $table->string('payment_method', 50)->nullable();
            $table->id('invoice_id')->nullable();
            $table->string('invoice_number', 100)->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
