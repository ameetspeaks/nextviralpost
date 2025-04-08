<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            if ($user) {
                $currentSubscription = $user->userSubscriptions()->where('status', 'active')->first();
                $view->with([
                    'hasSubscription' => (bool) $currentSubscription,
                    'subscriptionName' => $currentSubscription ? $currentSubscription->subscription->name : 'No Plan',
                    'isExpired' => $currentSubscription ? $currentSubscription->end_date->isPast() : true,
                    'remainingCredits' => $currentSubscription ? $currentSubscription->remaining_credits : 0
                ]);
            } else {
                $view->with([
                    'hasSubscription' => false,
                    'subscriptionName' => 'No Plan',
                    'isExpired' => true,
                    'remainingCredits' => 0
                ]);
            }
        });
    }
} 