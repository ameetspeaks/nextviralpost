<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SubscriptionService;

class CheckSubscriptionExpiry extends Command
{
    protected $signature = 'subscriptions:check-expiry';
    protected $description = 'Check for expiring subscriptions and send notifications';

    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        parent::__construct();
        $this->subscriptionService = $subscriptionService;
    }

    public function handle()
    {
        $this->info('Checking for expiring subscriptions...');
        $this->subscriptionService->checkSubscriptionExpiry();
        $this->info('Subscription expiry check completed.');
    }
} 