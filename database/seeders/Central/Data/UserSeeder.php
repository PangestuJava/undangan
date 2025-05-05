<?php

namespace Database\Seeders\Central\Data;

use App\Models\User;
use App\Models\UserPassword;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'username' => 'ittampan',
                'email' => 'ittampan.it@gmail.com'
            ],
            [
                'email_verified_at' => now(),
                'remember_token' => null,
            ]
        );

        UserPassword::firstOrCreate(
            ['user_id' => $user->id],
            ['password' => bcrypt('ittampan')]
        );
    }
}
