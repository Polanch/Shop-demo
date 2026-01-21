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
        // Create Admin account (only if doesn't exist)
        User::firstOrCreate(
            ['email' => 'admin@yame.com'],
            [
                'username' => 'Admin',
                'password' => Hash::make('12345'),
                'role' => 'Admin',
                'status' => 'active',
            ]
        );

        // Create Consumer account (only if doesn't exist)
        User::firstOrCreate(
            ['email' => 'john@yame.com'],
            [
                'username' => 'John',
                'password' => Hash::make('12345'),
                'role' => 'Consumer',
                'status' => 'active',
            ]
        );
    }
}
