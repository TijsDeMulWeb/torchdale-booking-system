<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escaperoom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('to_email');
            $table->string('type', 30)->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_logs');
    }
};
