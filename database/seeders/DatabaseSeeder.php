<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(CaracteristiqueSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(StockSeeder::class);
        $this->call(TauxTvaSeeder::class);
        $this->call(EntrepriseSeeder::class);
        $this->call(ActivityInitialSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
