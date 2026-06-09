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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('shipping_cost_domestic', 8, 2)->default(0)->after('selling_price');
            $table->decimal('shipping_cost_international', 8, 2)->default(0)->after('shipping_cost_domestic');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['shipping_cost_domestic', 'shipping_cost_international']);
        });
    }
};
