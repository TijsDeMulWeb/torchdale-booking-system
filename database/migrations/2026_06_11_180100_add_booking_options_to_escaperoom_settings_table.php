<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escaperoom_settings', function (Blueprint $table) {
            $table->json('hear_about_us_options')->nullable()->after('notify_new_order');
            $table->boolean('collect_player_names')->default(true)->after('hear_about_us_options');
        });
    }

    public function down(): void
    {
        Schema::table('escaperoom_settings', function (Blueprint $table) {
            $table->dropColumn(['hear_about_us_options', 'collect_player_names']);
        });
    }
};
