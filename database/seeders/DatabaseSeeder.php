<?php

namespace Database\Seeders;

use App\Models\DailyScoop;
use App\Models\Inventory;
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
        // \App\Models\User::factory(10)->create();
        $this->call(AdminSeeder::class);
        // Inventory::factory(35)->create();
        // DailyScoop::factory(5000)->create();
    }
}
