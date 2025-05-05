<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Central\Data\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
    }
}
