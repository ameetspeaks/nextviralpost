<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\CreditTransaction;
use Carbon\Carbon;

class SubscriptionService
{
    public function assignFreeTrial(User $user)
    {
        if ($user->hasUsedFreeTrial()) {
            return false;
        }

        $freeTrial = Subscription::where('name', 'Free Trial')->first();
        if (!$freeTrial) {
            return false;
        }

        $userSubscription = $user->userSubscriptions()->create([
            'subscription_id' => $freeTrial->id,
            'start_date' => now(),
            'end_date' => now()->addDays($freeTrial->duration),
            'total_credits' => $freeTrial->credits,
            'remaining_credits' => $freeTrial->credits,
            'status' => 'active'
        ]);

        // Update user preferences
        $user->preference()->update([
            'active_subscription_id' => $userSubscription->id
        ]);

        return true;
    }

    public function useCredits(User $user, int $amount = 1, string $description = 'Post generation')
    {
        if (!$user->hasActiveSubscription() || !$user->hasCredits()) {
            return false;
        }

        $subscription = $user->activeSubscription;
        
        if ($subscription->remaining_credits < $amount) {
            return false;
        }

        // Start transaction
        \DB::beginTransaction();
        try {
            // Deduct credits
            $subscription->remaining_credits -= $amount;
            $subscription->save();

            // Record transaction
            CreditTransaction::create([
                'user_id' => $user->id,
                'user_subscription_id' => $subscription->id,
                'amount' => -$amount,
                'description' => $description,
                'type' => 'debit'
            ]);

            // Check for low credits notification
            if ($user->preference->low_credits_notification && 
                $subscription->remaining_credits <= $user->preference->low_credits_threshold) {
                // TODO: Send notification
            }

            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollBack();
            return false;
        }
    }

    public function checkSubscriptionExpiry()
    {
        $expiringSubscriptions = UserSubscription::where('status', 'active')
            ->where('end_date', '<=', now()->addDays(3))
            ->get();

        foreach ($expiringSubscriptions as $subscription) {
            if ($subscription->user->preference->subscription_expiry_notification) {
                // TODO: Send notification
            }
        }
    }

    public function updateActiveSubscription(User $user)
    {
        $activeSubscription = $user->activeSubscription;
        if ($activeSubscription) {
            $user->preference()->update([
                'active_subscription_id' => $activeSubscription->id
            ]);
        }
    }
} 