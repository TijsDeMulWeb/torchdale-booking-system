<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Escaperoom;
use App\Models\EscaperoomAddress;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Country::create([
            'name' => 'België',
        ]);

        Country::create([
            'name' => 'Nederland',
        ]);

        Country::create([
            'name' => 'Deutsland',
        ]);

        Country::create([
            'name' => 'France',
        ]);

        Country::create([
            'name' => 'United Kingdom',
        ]);

        Escaperoom::create([
            'name' => 'Tales of Torchdale',
            'phone' => '0123456789',
            'email' => 'info@torchdale.be',
            'vat_number' => 'BE0123456789',
            'registration_number' => '0123456789',
        ]);

        EscaperoomAddress::create([
            'escaperoom_id' => 1,
            'street' => 'Herentalsebaan',
            'street_number' => '47',
            'postal_code' => '2980',
            'city' => 'Zoersel',
            'country_id' => 1,
            'is_primary' => true,
        ]);

        EscaperoomAddress::create([
            'escaperoom_id' => 1,
            'street' => 'Parking Kapelstraat',
            'postal_code' => '2980',
            'city' => 'Zoersel',
            'country_id' => 1,
        ]);
    }
}
