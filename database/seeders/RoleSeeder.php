<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'CEO',
                'description' => 'Chief Executive Officer',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Founder',
                'description' => 'Company Founder',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Marketing Manager',
                'description' => 'Marketing Department Manager',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics',
                    'manage_content'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Freelancer',
                'description' => 'Independent Content Creator',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Content Creator',
                'description' => 'Professional Content Creator',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Social Media Manager',
                'description' => 'Social Media Content Manager',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Digital Marketer',
                'description' => 'Digital Marketing Professional',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Product Manager',
                'description' => 'Product Development Manager',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Brand Manager',
                'description' => 'Brand Management Professional',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics',
                    'manage_content'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Community Manager',
                'description' => 'Community Engagement Manager',
                'permissions' => [
                    'create_posts',
                    'view_posts',
                    'edit_posts',
                    'delete_posts',
                    'view_dashboard',
                    'manage_profile',
                    'view_analytics'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'permissions' => $role['permissions'],
                    'is_active' => $role['is_active'],
                    'slug' => Str::slug($role['name'])
                ]
            );
        }
    }
} 