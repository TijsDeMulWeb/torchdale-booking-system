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
        Schema::table('time_slots', function (Blueprint $table) {
            // Column was already added in a partial run — only add the FK if missing
            if (!collect(DB::select("SHOW COLUMNS FROM time_slots LIKE 'language_id'"))->isEmpty()) {
                $table->foreign('language_id')->references('id')->on('languages')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('time_slots', function (Blueprint $table) {
            $table->dropForeignIfExists(['language_id']);
            $table->dropColumnIfExists('language_id');
        });
    }
};
