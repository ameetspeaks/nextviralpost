<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:superadmin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new superadmin user';

    /**
     * Execute the console command.
     */
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
        ]);

        $this->info("Superadmin user created successfully!");
        $this->info("Email: {$user->email}");
        $this->info("Password: {$password}");
        return 0;
    }
}
