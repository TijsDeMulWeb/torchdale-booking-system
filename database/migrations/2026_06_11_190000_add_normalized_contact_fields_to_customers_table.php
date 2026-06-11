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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('email_normalized')->nullable()->after('email');
            $table->string('phone_normalized')->nullable()->after('phone');

            $table->index('email_normalized');
            $table->index('phone_normalized');
        });

        DB::table('customers')->select('id', 'email', 'phone')->orderBy('id')->get()->each(function ($customer) {
            DB::table('customers')->where('id', $customer->id)->update([
                'email_normalized' => ContactNormalizer::normalizeEmail($customer->email),
                'phone_normalized' => ContactNormalizer::normalizePhone($customer->phone),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex(['email_normalized']);
            $table->dropIndex(['phone_normalized']);
            $table->dropColumn(['email_normalized', 'phone_normalized']);
        });
    }
};
