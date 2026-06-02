<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_first_name', 75)->nullable()->after('customer_id');
            $table->string('customer_last_name', 75)->nullable()->after('customer_first_name');
            $table->string('customer_email')->nullable()->after('customer_last_name');
            $table->string('customer_phone', 20)->nullable()->after('customer_email');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_first_name', 'customer_last_name', 'customer_email', 'customer_phone']);
        });
    }
};
