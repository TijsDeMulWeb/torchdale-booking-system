<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('languages')->insert([
            ['name' => 'Nederlands', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engels',     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Frans',      'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Duits',      'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Spaans',     'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
