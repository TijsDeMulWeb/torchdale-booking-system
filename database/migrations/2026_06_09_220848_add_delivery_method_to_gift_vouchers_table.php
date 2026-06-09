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
        Schema::table('gift_vouchers', function (Blueprint $table) {
            // mail | post | pickup
            $table->string('delivery_method', 20)->default('mail')->after('source');
        });
    }

    public function down(): void
    {
        Schema::table('gift_vouchers', function (Blueprint $table) {
            $table->dropColumn('delivery_method');
        });
    }
};
