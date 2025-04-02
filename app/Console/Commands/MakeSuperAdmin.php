<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeSuperAdmin extends Command
{
    protected $signature = 'make:superadmin {email}';
    protected $description = 'Make a user a superadmin';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        $user->is_superadmin = true;
        $user->save();

        $this->info("User {$user->name} is now a superadmin!");
        return 0;
    }
} 