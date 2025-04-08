<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\UserSubscription;
use Illuminate\Console\Command;

class AssignTrialPlan extends Command
{
    protected $signature = 'subscription:assign-trial {user_id}';
    protected $description = 'Assign the free trial plan to a user';

    public function handle()
    {
        $userId = $this->argument('user_id');
        
        // Get the free trial plan
        $trialPlan = Subscription::where('plan_type', 'free')->first();
        
        if (!$trialPlan) {
            $this->error('Free trial plan not found!');
            return 1;
        }
        
        // Check if user already has an active subscription
        $existingSubscription = UserSubscription::where('user_id', $userId)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->first();
            
        if ($existingSubscription) {
            $this->error('User already has an active subscription!');
            return 1;
        }
        
        // Create the trial subscription
        $userSubscription = UserSubscription::create([
            'user_id' => $userId,
            'subscription_id' => $trialPlan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($trialPlan->duration),
            'total_credits' => $trialPlan->credits,
            'remaining_credits' => $trialPlan->credits,
            'status' => 'active',
            'renewal_status' => false
        ]);
        
        $this->info('Successfully assigned free trial plan to user ' . $userId);
        $this->info('Subscription details:');
        $this->info('- Plan: ' . $trialPlan->name);
        $this->info('- Credits: ' . $trialPlan->credits);
        $this->info('- Duration: ' . $trialPlan->duration . ' days');
        $this->info('- End Date: ' . $userSubscription->end_date);
        
        return 0;
    }
} 