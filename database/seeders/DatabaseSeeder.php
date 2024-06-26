<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RegionSeeder::class,
            IndoBankSeeder::class,
            PerkaraSeeder::class,
            RuleATypesTableSeeder::class,
        ]);
    }
}
