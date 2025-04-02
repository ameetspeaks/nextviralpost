<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    protected $signature = 'create:superadmin {email} {password}';
    protected $description = 'Create a new superadmin user';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");
            return 1;
        }

        // Create new superadmin user
        $user = User::create([
            'name' => 'Super Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'is_superadmin' => true,
            'email_verified_at' => now(),
        ]);

        $this->info("Superadmin user created successfully!");
        $this->info("Email: {$user->email}");
        $this->info("Password: {$password}");
        return 0;
    }
} 