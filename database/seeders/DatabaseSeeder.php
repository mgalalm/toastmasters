<?php

namespace Database\Seeders;

use App\Models\Speech;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Database\Seeder;

// Assuming peech is a model similar to Speech

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()
            ->has(
                Speech::factory()->count(5)
            )
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin'), // Use bcrypt for password hashing
            ]);

        Workshop::factory()
            ->count(5)
            ->create();
    }
}
