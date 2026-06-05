<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\Chatbot;
use App\Models\Country;
use App\Models\Escaperoom;
use App\Models\EscaperoomAddress;
use App\Models\EscaperoomSetting;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Services\ApiKeyService;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
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

        // EscaperoomAddress::create([
        //     'escaperoom_id' => 1,
        //     'street' => 'Herentalsebaan',
        //     'house_number' => '47',
        //     'postal_code' => '2980',
        //     'city' => 'Zoersel',
        //     'country_id' => 1,
        //     'is_primary' => true,
        // ]);

        // EscaperoomAddress::create([
        //     'escaperoom_id' => 1,
        //     'street' => 'Parking Kapelstraat',
        //     'postal_code' => '2980',
        //     'city' => 'Zoersel',
        //     'country_id' => 1,
        // ]);

        $apiKeyService = new ApiKeyService();
        $keys = $apiKeyService->generateApiKeys();

        EscaperoomSetting::create([
            'escaperoom_id' => 1,
            'mollie_api_key' => null,
            'openai_api_key' => env('OPENAI_API_KEY'),
        ]);

        ApiKey::create([
            'escaperoom_id' => 1,
            'name' => 'Default API Key',
            'public_key' => $keys['public_key'],
            'secret_hash' => $keys['secret_hash_store'],
            'allowed_origin' => 'https://torchdale.be',
        ]);

        $this->command->info('=== API KEYS (sla deze op!) ===');
        $this->command->info('Public key: ' . $keys['public_key']);
        $this->command->info('Secret key: ' . $keys['secret_key']);
        $this->command->info('================================');

        User::create([
            'first_name' => 'Tijs',
            'last_name' => 'De Mul',
            'email' => 'tijs.de.mul@gmail.com',
            'password' => 'testtest',
            'escaperoom_id' => 1,
        ]);

        Chatbot::create([
            'escaperoom_id' => 1,
            'name' => 'Torchdale Support',
            'prompt' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, eaque. Molestias, voluptate. Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, eaque. Molestias, voluptate.',
        ]);

        // ProductCategory::create([
        //     'escaperoom_id' => 1,
        //     'name' => 'Bordspellen',
        // ]);

        // ProductCategory::create([
        //     'escaperoom_id' => 1,
        //     'name' => 'Shirts',
        // ]);

        // Product::create([
        //     'escaperoom_id' => 1,
        //     'category_id' => 1,
        //     'name' => 'Escape Room in a Box',
        //     'cost_price' => 15.00,
        //     'selling_price' => 30.00,
        //     'vat_percentage' => 21.00,
        //     'stock_quantity' => 50,
        // ]);

        // Product::create([
        //     'escaperoom_id' => 1,
        //     'category_id' => 2,
        //     'name' => 'Torchdale T-Shirt',
        //     'cost_price' => 10.00,
        //     'selling_price' => 20.00,
        //     'vat_percentage' => 6.00,
        //     'stock_quantity' => 100,
        // ]);

        // ProductImage::create([
        //     'product_id' => 2,
        //     'url' => 'https://placehold.co/400x400',
        //     'alt_text' => 'Torchdale T-Shirt',
        //     'is_primary' => true,
        // ]);

        // Room::create([
        //     'escaperoom_id' => 1,
        //     'escaperoom_address_id' => 1,
        //     'name' => 'The Toy Factory',
        //     'duration' => 75,
        //     'min_players' => 2,
        //     'max_players' => 6,
        //     'min_age' => 16,
        //     'url' => 'https://torchdale.be/rooms/the-toy-factory',
        //     'active_from' => now(),
        //     'color' => '#FF5733',
        // ]);


        Permission::create(['name' => 'view chatbot']);
        Permission::create(['name' => 'edit chatbot']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        User::find(1)->assignRole('admin');
    }
}
