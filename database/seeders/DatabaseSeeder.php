<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin account
        User::create([
            'username' => 'Admin',
            'email' => 'admin@yame.com',
            'password' => Hash::make('12345'),
            'role' => 'Admin',
            'status' => 'active',
        ]);

        // Create Consumer account
        User::create([
            'username' => 'John',
            'email' => 'john@yame.com',
            'password' => Hash::make('12345'),
            'role' => 'Consumer',
            'status' => 'active',
        ]);
    }
}
