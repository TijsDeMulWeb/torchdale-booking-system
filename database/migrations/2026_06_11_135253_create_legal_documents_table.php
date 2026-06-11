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
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->onDelete('cascade');
            $table->string('type', 50);
            $table->unsignedInteger('version');
            $table->string('file_path');
            $table->string('original_filename')->nullable();
            $table->timestamps();

            $table->unique(['escaperoom_id', 'type', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
    }
};
