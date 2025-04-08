<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\SubscriptionService;

class TestCreditDeduction extends Command
{
    protected $signature = 'test:credit-deduction {amount=1}';
    protected $description = 'Test credit deduction functionality for admin user';

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

        if (!$admin->hasActiveSubscription()) {
            $this->error('Admin user has no active subscription!');
            return 1;
        }

        $amount = $this->argument('amount');
        $this->info("Current credits: {$admin->activeSubscription->remaining_credits}");
        
        if ($this->subscriptionService->useCredits($admin, $amount, 'Test credit deduction')) {
            $this->info("Successfully deducted {$amount} credit(s)!");
            $this->info("Remaining credits: {$admin->activeSubscription->fresh()->remaining_credits}");
        } else {
            $this->error('Failed to deduct credits!');
        }

        return 0;
    }
} 