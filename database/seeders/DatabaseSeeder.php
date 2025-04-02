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
        // Create superadmin if it doesn't exist
        if (!User::where('email', 'admin@nextviralpost.com')->exists()) {
            User::factory()->create([
                'full_name' => 'Super Admin',
                'email' => 'admin@nextviralpost.com',
                'password' => bcrypt('Admin@123!'),
                'is_superadmin' => true,
            ]);
        }

        // Create test user if it doesn't exist
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'full_name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            MasterDataSeeder::class,
            PostTypeSeeder::class,
            ToneSeeder::class,
            PromptTemplateSeeder::class,
            ProductLaunchPromptTemplateSeeder::class,
            ViralTemplateSeeder::class,
        ]);
    }
}
