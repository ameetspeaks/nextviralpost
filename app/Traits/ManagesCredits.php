<?php

namespace App\Traits;

use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;
use Exception;

trait ManagesCredits
{
    protected function canPerformAction(int $requiredCredits = 1): bool
    {
        $user = auth()->user();
        $activeSubscription = $user->activeSubscription;

        if (!$activeSubscription) {
            return false;
        }

        return $activeSubscription->remaining_credits >= $requiredCredits;
    }

    protected function deductCredits(int $amount, string $description = '')
    {
        $user = auth()->user();
        $activeSubscription = $user->activeSubscription;

        if (!$activeSubscription) {
            throw new Exception('No active subscription found.');
        }

        if ($activeSubscription->remaining_credits < $amount) {
            throw new Exception('Insufficient credits.');
        }

        DB::beginTransaction();
        try {
            // Create credit transaction
            CreditTransaction::create([
                'user_id' => $user->id,
                'user_subscription_id' => $activeSubscription->id,
                'amount' => -$amount,
                'type' => 'usage',
                'description' => $description,
                'balance' => $activeSubscription->remaining_credits - $amount
            ]);

            // Update remaining credits
            $activeSubscription->remaining_credits -= $amount;
            $activeSubscription->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 