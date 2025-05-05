<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Central\Data\UserSeeder;
use Database\Seeders\Central\Data\TenantSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(TenantSeeder::class);
    }
}
