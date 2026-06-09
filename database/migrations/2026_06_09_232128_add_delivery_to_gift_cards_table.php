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
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->string('delivery_method', 20)->default('mail')->after('valid_until');
            $table->decimal('shipping_cost', 8, 2)->default(0)->after('delivery_method');
        });
    }

    public function down(): void
    {
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->dropColumn(['delivery_method', 'shipping_cost']);
        });
    }
};
