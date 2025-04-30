<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test1@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test2@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test3@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test4@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test5@example.com',
            'password' => 'password',
            'role' => 'user',
        ]);
    }
}
