<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->boolean('allow_mail_delivery')->default(true)->after('shipping_cost');
            $table->boolean('allow_post_delivery')->default(true)->after('allow_mail_delivery');
            $table->boolean('allow_pickup_delivery')->default(true)->after('allow_post_delivery');
        });
    }

    public function down(): void
    {
        Schema::table('gift_cards', function (Blueprint $table) {
            $table->dropColumn(['allow_mail_delivery', 'allow_post_delivery', 'allow_pickup_delivery']);
        });
    }
};
