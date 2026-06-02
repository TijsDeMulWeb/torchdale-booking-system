<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_business')->default(false)->after('customer_phone');
            $table->string('company_name', 255)->nullable()->after('is_business');
            $table->string('vat_number', 50)->nullable()->after('company_name');
            $table->string('registration_number', 50)->nullable()->after('vat_number');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['is_business', 'company_name', 'vat_number', 'kvk_number']);
        });
    }
};
