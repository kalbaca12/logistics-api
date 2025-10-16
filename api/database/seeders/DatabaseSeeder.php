<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WarehouseSeeder::class,
            ShipmentSeeder::class,
            PackageSeeder::class,
        ]);
    }
}
//php artisan migrate:fresh --seed
