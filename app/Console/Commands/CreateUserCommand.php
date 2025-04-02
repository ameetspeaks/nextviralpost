<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    protected $signature = 'create:user {email} {password} {--superadmin}';
    protected $description = 'Create a new user';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $isSuperadmin = $this->option('superadmin');

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");
            return 1;
        }

        // Create new user
        $user = User::create([
            'name' => ucfirst(explode('@', $email)[0]),
            'email' => $email,
            'password' => Hash::make($password),
            'is_superadmin' => $isSuperadmin,
        ]);

        $this->info("User created successfully!");
        $this->info("Name: {$user->name}");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
        $this->info("Superadmin: " . ($isSuperadmin ? 'Yes' : 'No'));

        return 0;
    }
} 