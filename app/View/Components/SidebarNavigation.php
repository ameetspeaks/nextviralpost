<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class SidebarNavigation extends Component
{
    public $user;
    public $activeSubscription;
    public $subscriptionName;
    public $remainingCredits;
    public $isExpired;
    public $hasSubscription;

    public function __construct()
    {
        $this->user = Auth::user();
        $subscription = $this->user->userSubscriptions()->with('subscription')->latest()->first();
        $this->hasSubscription = !is_null($subscription);
        $this->activeSubscription = $subscription;
        $this->subscriptionName = $subscription?->subscription?->name ?? 'No Plan';
        $this->remainingCredits = $subscription?->remaining_credits ?? 0;
        $this->isExpired = $subscription ? ($subscription->end_date < now() || $subscription->status !== 'active') : true;
    }

    public function render()
    {
        return view('components.sidebar-navigation', [
            'activeSubscription' => $this->activeSubscription,
            'subscriptionName' => $this->subscriptionName,
            'remainingCredits' => $this->remainingCredits,
            'isExpired' => $this->isExpired,
            'hasSubscription' => $this->hasSubscription
        ]);
    }
} 