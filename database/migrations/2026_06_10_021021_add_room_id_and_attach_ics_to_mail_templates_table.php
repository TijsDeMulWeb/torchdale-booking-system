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
        Schema::table('mail_templates', function (Blueprint $table) {
            if (! Schema::hasColumn('mail_templates', 'room_id')) {
                $table->unsignedBigInteger('room_id')->default(0)->after('type');
            }
            if (! Schema::hasColumn('mail_templates', 'attach_ics')) {
                $table->boolean('attach_ics')->default(false)->after('body');
            }

            $table->unique(['escaperoom_id', 'type', 'room_id', 'locale']);
            $table->dropUnique(['escaperoom_id', 'type', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->unique(['escaperoom_id', 'type', 'locale']);
            $table->dropUnique(['escaperoom_id', 'type', 'room_id', 'locale']);

            $table->dropColumn(['room_id', 'attach_ics']);
        });
    }
};
