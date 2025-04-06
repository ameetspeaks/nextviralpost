<?php

namespace App\Console\Commands;

use App\Models\UserSubscription;
use Illuminate\Console\Command;

class CheckExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expired';
    protected $description = 'Check and update expired subscriptions';

    public function handle()
    {
        $expiredSubscriptions = UserSubscription::where('status', 'active')
            ->where('end_date', '<=', now())
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['status' => 'expired']);
            
            // Notify user about expired subscription
            $subscription->user->notify(new SubscriptionExpiredNotification($subscription));
        }

        $this->info('Checked and updated ' . $expiredSubscriptions->count() . ' expired subscriptions.');
    }
} 