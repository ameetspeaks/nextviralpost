<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\CreditTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function select()
    {
        // Get all active subscriptions
        $subscriptions = Subscription::where('is_active', true)->get();
        
        // Log the subscriptions for debugging
        Log::info('Subscriptions fetched:', ['count' => $subscriptions->count(), 'subscriptions' => $subscriptions->toArray()]);
        
        // Check if we have the expected number of subscriptions
        if ($subscriptions->count() !== 3) {
            Log::warning('Expected 3 subscriptions but found ' . $subscriptions->count());
        }
        
        return view('subscription.select', compact('subscriptions'));
    }

    public function startTrial(Subscription $subscription)
    {
        if ($subscription->plan_type !== 'free') {
            return redirect()->route('subscription.select')
                ->with('error', 'Invalid subscription type for trial.');
        }

        // Check if user already has an active subscription
        if (Auth::user()->hasActiveSubscription()) {
            return redirect()->route('dashboard')
                ->with('error', 'You already have an active subscription.');
        }

        // Create trial subscription
        $userSubscription = UserSubscription::create([
            'user_id' => Auth::id(),
            'subscription_id' => $subscription->id,
            'start_date' => now(),
            'end_date' => now()->addDays($subscription->duration),
            'total_credits' => $subscription->credits,
            'remaining_credits' => $subscription->credits,
            'status' => 'active',
            'payment_method' => 'free',
        ]);

        // Update user preferences
        Auth::user()->preference()->update([
            'active_subscription_id' => $userSubscription->id
        ]);

        // Create initial credit transaction
        CreditTransaction::createTransaction(
            $userSubscription,
            $subscription->credits,
            'initial',
            'Initial credits from trial subscription'
        );

        return redirect()->route('dashboard')
            ->with('success', 'Your free trial has started!');
    }

    public function purchase(Subscription $subscription)
    {
        if ($subscription->plan_type === 'free') {
            return redirect()->route('subscription.select')
                ->with('error', 'Please use the trial option for free plans.');
        }

        // For now, we'll just show a coming soon message
        return redirect()->route('subscription.select')
            ->with('info', 'Payment integration coming soon!');
    }

    public function manage()
    {
        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;
        $subscriptions = Subscription::where('is_active', true)
            ->where('plan_type', '!=', 'free')
            ->get();
        $creditTransactions = $user->creditTransactions()
            ->with('post')
            ->latest()
            ->paginate(10);

        return view('subscription.manage', compact(
            'activeSubscription',
            'subscriptions',
            'creditTransactions'
        ));
    }

    public function analytics()
    {
        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;

        if (!$activeSubscription) {
            return redirect()->route('subscription.select')
                ->with('error', 'You need an active subscription to view analytics.');
        }

        // Get credit usage data for the last 30 days
        $creditUsage = $user->creditTransactions()
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->get();

        // Calculate usage statistics
        $totalCreditsUsed = abs($creditUsage->sum('total'));
        $averageDailyUsage = $totalCreditsUsed / 30;
        $remainingDays = $activeSubscription->end_date->diffInDays(now());
        $projectedUsage = $averageDailyUsage * $remainingDays;

        return view('subscription.analytics', compact(
            'activeSubscription',
            'creditUsage',
            'totalCreditsUsed',
            'averageDailyUsage',
            'projectedUsage'
        ));
    }

    public function cancel()
    {
        $user = Auth::user();
        $activeSubscription = $user->activeSubscription;

        if (!$activeSubscription) {
            return redirect()->route('subscription.manage')
                ->with('error', 'No active subscription found.');
        }

        $activeSubscription->update([
            'renewal_status' => false,
            'status' => 'cancelled'
        ]);

        return redirect()->route('subscription.manage')
            ->with('success', 'Your subscription has been cancelled. It will remain active until the end of the current billing period.');
    }
} 