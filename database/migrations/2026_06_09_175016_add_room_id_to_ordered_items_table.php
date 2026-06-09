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
            $table->foreignId('room_id')->nullable()->after('time_slot_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('ordered_items', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });
    }
};
