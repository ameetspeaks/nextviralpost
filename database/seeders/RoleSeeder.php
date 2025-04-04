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
                'name' => 'Super Admin',
                'description' => 'Has full access to all features',
                'permissions' => [
                    'edit_content' => true,
                    'manage_users' => true,
                    'manage_roles' => true
                ],
                'slug' => 'super-admin',
                'is_active' => true
            ],
            [
                'name' => 'Content Manager',
                'description' => 'Can manage content and templates',
                'permissions' => [
                    'edit_content' => true,
                    'manage_users' => false,
                    'manage_roles' => false
                ],
                'slug' => 'content-manager',
                'is_active' => true
            ],
            [
                'name' => 'User',
                'description' => 'Regular user with basic access',
                'permissions' => [
                    'edit_content' => false,
                    'manage_users' => false,
                    'manage_roles' => false
                ],
                'slug' => 'user',
                'is_active' => true
            ]
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }
    }
} 