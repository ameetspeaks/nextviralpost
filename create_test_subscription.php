<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;

// Get the first user
$user = User::find(1);
if (!$user) {
    echo "User not found!\n";
    exit(1);
}

// Get the Creator plan
$subscription = Subscription::where('plan_type', 'creator')->first();
if (!$subscription) {
    echo "Subscription plan not found!\n";
    exit(1);
}

// Create the subscription
$userSubscription = UserSubscription::create([
    'user_id' => $user->id,
    'subscription_id' => $subscription->id,
    'status' => 'active',
    'start_date' => now(),
    'end_date' => now()->addMonth(),
    'total_credits' => $subscription->credits,
    'remaining_credits' => $subscription->credits
]);

echo "Successfully created subscription:\n";
echo "User: {$user->name}\n";
echo "Plan: {$subscription->name}\n";
echo "Credits: {$subscription->credits}\n";
echo "End Date: {$userSubscription->end_date}\n"; 