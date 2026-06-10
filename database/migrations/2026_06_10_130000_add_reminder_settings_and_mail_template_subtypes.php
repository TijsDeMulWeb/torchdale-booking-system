<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escaperoom_settings', function (Blueprint $table) {
            $table->unsignedSmallInteger('reminder_days_before')->nullable()->after('confirmation_gift_card_url');
        });

        Schema::table('time_slots', function (Blueprint $table) {
            $table->timestamp('reminder_sent_at')->nullable()->after('language_id');
        });

        DB::table('mail_templates')->where('type', 'room')->update(['type' => 'room_confirmation']);
    }

    public function down(): void
    {
        DB::table('mail_templates')->where('type', 'room_confirmation')->update(['type' => 'room']);

        Schema::table('time_slots', function (Blueprint $table) {
            $table->dropColumn('reminder_sent_at');
        });

        Schema::table('escaperoom_settings', function (Blueprint $table) {
            $table->dropColumn('reminder_days_before');
        });
    }
};
