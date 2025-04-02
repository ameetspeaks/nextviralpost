<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Industry;
use App\Models\Role;
use App\Models\Interest;
use Illuminate\Support\Str;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Industries
        $industries = [
            'Technology',
            'Marketing',
            'Education',
            'E-commerce',
            'Healthcare',
            'Finance',
            'Entertainment',
            'Other'
        ];

        foreach ($industries as $industry) {
            $slug = Str::slug($industry);
            if (!Industry::where('slug', $slug)->exists()) {
                Industry::create([
                    'name' => $industry,
                    'slug' => $slug,
                    'is_active' => true
                ]);
            }
        }

        // Seed Roles
        $roles = [
            'Founder',
            'Student',
            'Creator',
            'Marketer',
            'Freelancer',
            'Other'
        ];

        foreach ($roles as $role) {
            $slug = Str::slug($role);
            if (!Role::where('slug', $slug)->exists()) {
                Role::create([
                    'name' => $role,
                    'slug' => $slug,
                    'is_active' => true
                ]);
            }
        }

        // Seed Interests (Social Media Platforms)
        $interests = [
            'LinkedIn',
            'Instagram',
            'Twitter',
            'Youtube',
            'Facebook',
            'TikTok'
        ];

        foreach ($interests as $interest) {
            $slug = Str::slug($interest);
            if (!Interest::where('slug', $slug)->exists()) {
                Interest::create([
                    'name' => $interest,
                    'slug' => $slug,
                    'is_active' => true
                ]);
            }
        }
    }
} 