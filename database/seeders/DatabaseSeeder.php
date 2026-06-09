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
use App\Models\Admin;
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
        $this->call(CountrySeeder::class);

        Admin::create([
            'first_name' => 'Tijs',
            'last_name' => 'De Mul',
            'email' => 'tijs.de.mul@gmail.com',
            'password' => 'testtest',
        ]);

        Permission::create(['name' => 'view chatbot']);
        Permission::create(['name' => 'edit chatbot']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
