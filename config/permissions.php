<?php

// Catalogus van alle permissions in de applicatie, gegroepeerd per onderdeel.
// Wordt gebruikt door de PermissionSeeder en de "Rollen & rechten"-pagina's.

return [
    'Dashboard' => [
        'view dashboard',
        'manage bookings',
    ],
    'Klanten' => [
        'view customers',
        'create customers',
        'edit customers',
        'delete customers',
    ],
    'Bestellingen' => [
        'view orders',
    ],
    'Kamers' => [
        'view rooms',
        'create rooms',
        'edit rooms',
        'delete rooms',
    ],
    'Producten' => [
        'view products',
        'create products',
        'edit products',
        'delete products',
    ],
    'Kortingsbonnen' => [
        'view coupons',
        'create coupons',
        'edit coupons',
        'delete coupons',
    ],
    'Cadeaubonnen' => [
        'view gift cards',
        'create gift cards',
        'edit gift cards',
        'delete gift cards',
    ],
    'Widgets' => [
        'view widgets',
        'edit widgets',
    ],
    'Chatbot' => [
        'view chatbot',
        'edit chatbot',
    ],
    'Mailsjablonen' => [
        'view mail templates',
        'edit mail templates',
    ],
    'Gebruikers' => [
        'view users',
        'create users',
        'edit users',
        'delete users',
    ],
    'Rollen & rechten' => [
        'view roles',
        'create roles',
        'edit roles',
        'delete roles',
    ],
    'Instellingen' => [
        'view settings',
        'edit settings',
    ],
];
