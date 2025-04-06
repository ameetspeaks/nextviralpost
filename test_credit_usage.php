<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\CreditTransaction;

// Get the first user
$user = User::find(1);
if (!$user) {
    echo "User not found!\n";
    exit(1);
}

$activeSubscription = $user->activeSubscription;
if (!$activeSubscription) {
    echo "No active subscription found!\n";
    exit(1);
}

// Test credit usage
$creditsToUse = 5;
$remainingBefore = $activeSubscription->remaining_credits;

// Create a credit transaction
$transaction = CreditTransaction::create([
    'user_id' => $user->id,
    'user_subscription_id' => $activeSubscription->id,
    'amount' => -$creditsToUse,
    'type' => 'usage',
    'description' => 'Test credit usage - Generated a post',
    'balance' => $remainingBefore - $creditsToUse
]);

// Update remaining credits
$activeSubscription->remaining_credits -= $creditsToUse;
$activeSubscription->save();

echo "Credit Transaction Test:\n";
echo "Previous Balance: {$remainingBefore}\n";
echo "Credits Used: {$creditsToUse}\n";
echo "New Balance: {$activeSubscription->remaining_credits}\n";
echo "Transaction ID: {$transaction->id}\n"; 