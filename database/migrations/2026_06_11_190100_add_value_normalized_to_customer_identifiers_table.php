<?php

use App\Support\ContactNormalizer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_identifiers', function (Blueprint $table) {
            $table->string('value_normalized')->nullable()->after('value');

            $table->index(['type', 'value_normalized']);
        });

        DB::table('customer_identifiers')->select('id', 'type', 'value')->orderBy('id')->get()->each(function ($identifier) {
            $normalized = match ($identifier->type) {
                'email' => ContactNormalizer::normalizeEmail($identifier->value),
                'phone' => ContactNormalizer::normalizePhone($identifier->value),
                default => $identifier->value,
            };

            DB::table('customer_identifiers')->where('id', $identifier->id)->update([
                'value_normalized' => $normalized,
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('customer_identifiers', function (Blueprint $table) {
            $table->dropIndex(['type', 'value_normalized']);
            $table->dropColumn('value_normalized');
        });
    }
};
