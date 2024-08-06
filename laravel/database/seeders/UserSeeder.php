<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Test2 User2',
            'email' => 'test2@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
