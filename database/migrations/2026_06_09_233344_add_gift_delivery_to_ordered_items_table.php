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
        Schema::table('ordered_items', function (Blueprint $table) {
            $table->string('gift_delivery_method', 20)->nullable()->after('gift_card_id');
            $table->decimal('gift_shipping_cost', 8, 2)->nullable()->default(0)->after('gift_delivery_method');
        });
    }

    public function down(): void
    {
        Schema::table('ordered_items', function (Blueprint $table) {
            $table->dropColumn(['gift_delivery_method', 'gift_shipping_cost']);
        });
    }
};
