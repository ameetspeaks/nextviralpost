<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Console\Command;

class CreateTestSubscription extends Command
{
    protected $signature = 'subscription:create-test {user_id} {--plan=creator}';
    protected $description = 'Create a test subscription for a user';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $planType = $this->option('plan');

        $user = User::find($userId);
        if (!$user) {
            $this->error('User not found!');
            return 1;
        }

        $subscription = Subscription::where('type', $planType)->first();
        if (!$subscription) {
            $this->error('Subscription plan not found!');
            return 1;
        }

        // Create the subscription
        $userSubscription = UserSubscription::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'remaining_credits' => $subscription->credits
        ]);

        $this->info("Successfully created {$planType} subscription for user {$user->name}");
        $this->info("Subscription ID: {$userSubscription->id}");
        $this->info("Credits: {$subscription->credits}");
        $this->info("End Date: {$userSubscription->end_date}");

        return 0;
    }
} 