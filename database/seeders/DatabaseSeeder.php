<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create superadmin if it doesn't exist
        if (!User::where('email', 'admin@nextviralpost.com')->exists()) {
            User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'admin@nextviralpost.com',
                'password' => Hash::make('Admin@123!'),
                'is_superadmin' => true,
            ]);
        }

        // Create test user if it doesn't exist
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            IndustrySeeder::class,
            PostTypeSeeder::class,
            PostToneSeeder::class,
            UserPreferenceSeeder::class,
            PromptTemplateSeeder::class,
            PostSeeder::class,
            ViralTemplateSeeder::class,
        ]);
    }
}
