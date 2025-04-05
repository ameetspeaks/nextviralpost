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
                'name' => 'Admin',
                'description' => 'Administrator with full access',
                'permissions' => ['*'],
                'is_active' => true,
            ],
            [
                'name' => 'User',
                'description' => 'Regular user with basic access',
                'permissions' => ['create_posts', 'view_posts', 'edit_posts'],
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'description' => $role['description'],
                'permissions' => $role['permissions'],
                'is_active' => $role['is_active'],
                'slug' => Str::slug($role['name'])
            ]);
        }
    }
} 