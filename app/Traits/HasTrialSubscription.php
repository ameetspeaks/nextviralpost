<?php

namespace App\Traits;

use App\Models\Subscription;
use Carbon\Carbon;

trait HasTrialSubscription
{
    public function assignTrialSubscription()
    {
        // Get the trial subscription plan
        $trialPlan = Subscription::where('plan_type', 'trial')->first();
        
        if (!$trialPlan) {
            return false;
        }

        // Check if user already had a trial
        if ($this->hasUsedFreeTrial()) {
            return false;
        }

        // Create user subscription
        $this->userSubscriptions()->create([
            'subscription_id' => $trialPlan->id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($trialPlan->duration),
            'total_credits' => $trialPlan->credits,
            'remaining_credits' => $trialPlan->credits,
            'status' => 'active',
            'renewal_status' => false
        ]);

        return true;
    }
} 