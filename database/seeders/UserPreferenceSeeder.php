<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPreference;
use App\Models\User;
use App\Models\Role;
use App\Models\Industry;

class UserPreferenceSeeder extends Seeder
{
    public function run()
    {
        // Get the first user (admin)
        $adminUser = User::where('is_superadmin', true)->first();
        
        // Get the first regular user
        $regularUser = User::where('is_superadmin', false)->first();

        // Get roles
        $adminRole = Role::where('slug', 'admin')->first();
        $userRole = Role::where('slug', 'user')->first();

        // Get a sample industry
        $industry = Industry::first();

        // Create admin preferences
        if ($adminUser) {
            UserPreference::create([
                'user_id' => $adminUser->id,
                'role_id' => $adminRole->id,
                'industry_id' => $industry->id,
                'onboarding_completed' => true,
            ]);
        }

        // Create regular user preferences
        if ($regularUser) {
            UserPreference::create([
                'user_id' => $regularUser->id,
                'role_id' => $userRole->id,
                'industry_id' => $industry->id,
                'onboarding_completed' => true,
            ]);
        }
    }
} 