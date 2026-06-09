<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            // Buurlanden & meest gebruikte
            ['name' => 'België',                    'iso_code' => 'BE'],
            ['name' => 'Nederland',                 'iso_code' => 'NL'],
            ['name' => 'Duitsland',                 'iso_code' => 'DE'],
            ['name' => 'Frankrijk',                 'iso_code' => 'FR'],
            ['name' => 'Luxemburg',                 'iso_code' => 'LU'],
            ['name' => 'Verenigd Koninkrijk',       'iso_code' => 'GB'],

            // Rest van Europa
            ['name' => 'Albanië',                   'iso_code' => 'AL'],
            ['name' => 'Andorra',                   'iso_code' => 'AD'],
            ['name' => 'Bosnië-Herzegovina',        'iso_code' => 'BA'],
            ['name' => 'Bulgarije',                 'iso_code' => 'BG'],
            ['name' => 'Cyprus',                    'iso_code' => 'CY'],
            ['name' => 'Denemarken',                'iso_code' => 'DK'],
            ['name' => 'Estland',                   'iso_code' => 'EE'],
            ['name' => 'Finland',                   'iso_code' => 'FI'],
            ['name' => 'Griekenland',               'iso_code' => 'GR'],
            ['name' => 'Hongarije',                 'iso_code' => 'HU'],
            ['name' => 'Ierland',                   'iso_code' => 'IE'],
            ['name' => 'IJsland',                   'iso_code' => 'IS'],
            ['name' => 'Italië',                    'iso_code' => 'IT'],
            ['name' => 'Kosovo',                    'iso_code' => 'XK'],
            ['name' => 'Kroatië',                   'iso_code' => 'HR'],
            ['name' => 'Letland',                   'iso_code' => 'LV'],
            ['name' => 'Liechtenstein',             'iso_code' => 'LI'],
            ['name' => 'Litouwen',                  'iso_code' => 'LT'],
            ['name' => 'Malta',                     'iso_code' => 'MT'],
            ['name' => 'Moldavië',                  'iso_code' => 'MD'],
            ['name' => 'Monaco',                    'iso_code' => 'MC'],
            ['name' => 'Montenegro',                'iso_code' => 'ME'],
            ['name' => 'Noord-Macedonië',           'iso_code' => 'MK'],
            ['name' => 'Noorwegen',                 'iso_code' => 'NO'],
            ['name' => 'Oekraïne',                  'iso_code' => 'UA'],
            ['name' => 'Oostenrijk',                'iso_code' => 'AT'],
            ['name' => 'Polen',                     'iso_code' => 'PL'],
            ['name' => 'Portugal',                  'iso_code' => 'PT'],
            ['name' => 'Roemenië',                  'iso_code' => 'RO'],
            ['name' => 'Rusland',                   'iso_code' => 'RU'],
            ['name' => 'San Marino',                'iso_code' => 'SM'],
            ['name' => 'Servië',                    'iso_code' => 'RS'],
            ['name' => 'Slovenië',                  'iso_code' => 'SI'],
            ['name' => 'Slowakije',                 'iso_code' => 'SK'],
            ['name' => 'Spanje',                    'iso_code' => 'ES'],
            ['name' => 'Tsjechië',                  'iso_code' => 'CZ'],
            ['name' => 'Turkije',                   'iso_code' => 'TR'],
            ['name' => 'Vaticaanstad',              'iso_code' => 'VA'],
            ['name' => 'Wit-Rusland',               'iso_code' => 'BY'],
            ['name' => 'Zweden',                    'iso_code' => 'SE'],
            ['name' => 'Zwitserland',               'iso_code' => 'CH'],

            // Noord-Amerika
            ['name' => 'Canada',                    'iso_code' => 'CA'],
            ['name' => 'Mexico',                    'iso_code' => 'MX'],
            ['name' => 'Verenigde Staten',          'iso_code' => 'US'],

            // Zuid-Amerika
            ['name' => 'Argentinië',                'iso_code' => 'AR'],
            ['name' => 'Brazilië',                  'iso_code' => 'BR'],
            ['name' => 'Chili',                     'iso_code' => 'CL'],
            ['name' => 'Colombia',                  'iso_code' => 'CO'],
            ['name' => 'Peru',                      'iso_code' => 'PE'],

            // Azië
            ['name' => 'China',                     'iso_code' => 'CN'],
            ['name' => 'India',                     'iso_code' => 'IN'],
            ['name' => 'Indonesië',                 'iso_code' => 'ID'],
            ['name' => 'Japan',                     'iso_code' => 'JP'],
            ['name' => 'Maleisië',                  'iso_code' => 'MY'],
            ['name' => 'Pakistan',                  'iso_code' => 'PK'],
            ['name' => 'Filipijnen',                'iso_code' => 'PH'],
            ['name' => 'Singapore',                 'iso_code' => 'SG'],
            ['name' => 'Zuid-Korea',                'iso_code' => 'KR'],
            ['name' => 'Thailand',                  'iso_code' => 'TH'],
            ['name' => 'Vietnam',                   'iso_code' => 'VN'],

            // Midden-Oosten
            ['name' => 'Israël',                    'iso_code' => 'IL'],
            ['name' => 'Jordanië',                  'iso_code' => 'JO'],
            ['name' => 'Libanon',                   'iso_code' => 'LB'],
            ['name' => 'Qatar',                     'iso_code' => 'QA'],
            ['name' => 'Saudi-Arabië',              'iso_code' => 'SA'],
            ['name' => 'Verenigde Arabische Emiraten', 'iso_code' => 'AE'],

            // Afrika
            ['name' => 'Algerije',                  'iso_code' => 'DZ'],
            ['name' => 'Egypte',                    'iso_code' => 'EG'],
            ['name' => 'Ethiopië',                  'iso_code' => 'ET'],
            ['name' => 'Marokko',                   'iso_code' => 'MA'],
            ['name' => 'Nigeria',                   'iso_code' => 'NG'],
            ['name' => 'Zuid-Afrika',               'iso_code' => 'ZA'],
            ['name' => 'Tunesië',                   'iso_code' => 'TN'],

            // Oceanië
            ['name' => 'Australië',                 'iso_code' => 'AU'],
            ['name' => 'Nieuw-Zeeland',             'iso_code' => 'NZ'],
        ];

        // Wis de oude records en vervang ze (foreign key checks tijdelijk uit)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('countries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name'       => $country['name'],
                'iso_code'   => $country['iso_code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
