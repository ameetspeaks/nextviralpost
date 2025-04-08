<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Subscription;
use App\Services\SubscriptionService;

class AssignAdminPlan extends Command
{
    protected $signature = 'admin:assign-plan {plan=free_trial}';
    protected $description = 'Assign a subscription plan to the admin user';

    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        parent::__construct();
        $this->subscriptionService = $subscriptionService;
    }

    public function handle()
    {
        $admin = User::where('email', 'admin@example.com')->first();
        
        if (!$admin) {
            $this->error('Admin user not found!');
            return 1;
        }

        $planName = $this->argument('plan');
        $subscription = Subscription::where('name', 'Free Trial')->first();

        if (!$subscription) {
            $this->error('Subscription plan not found!');
            return 1;
        }

        // Create user subscription
        $userSubscription = $admin->userSubscriptions()->create([
            'subscription_id' => $subscription->id,
            'start_date' => now(),
            'end_date' => now()->addDays($subscription->duration),
            'total_credits' => $subscription->credits,
            'remaining_credits' => $subscription->credits,
            'status' => 'active'
        ]);

        // Update user preferences
        $admin->preference()->update([
            'active_subscription_id' => $userSubscription->id
        ]);

        $this->info("Successfully assigned {$subscription->name} plan to admin user!");
        $this->info("Total Credits: {$subscription->credits}");
        $this->info("Subscription valid until: " . $userSubscription->end_date->format('Y-m-d'));
        
        return 0;
    }
} 