<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escaperoom_settings', function (Blueprint $table) {
            $table->boolean('notify_new_order')->default(true)->after('reminder_days_before');
        });
    }

    public function down(): void
    {
        Schema::table('escaperoom_settings', function (Blueprint $table) {
            $table->dropColumn('notify_new_order');
        });
    }
};
