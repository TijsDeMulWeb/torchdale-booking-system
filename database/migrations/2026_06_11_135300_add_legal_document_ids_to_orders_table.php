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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('privacy_policy_legal_document_id')->nullable()->after('invoice_number')->constrained('legal_documents')->nullOnDelete();
            $table->foreignId('terms_conditions_legal_document_id')->nullable()->after('privacy_policy_legal_document_id')->constrained('legal_documents')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('privacy_policy_legal_document_id');
            $table->dropConstrainedForeignId('terms_conditions_legal_document_id');
        });
    }
};
