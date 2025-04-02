<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UpdateSuperAdminPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:superadmin-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the password for a superadmin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }

        // Update password
        $user->password = Hash::make($password);
        $user->is_superadmin = true;
        $user->save();

        $this->info("Password updated successfully for {$email}!");
        $this->info("New password: {$password}");
        return 0;
    }
}
