<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'start_date',
        'end_date',
        'total_credits',
        'remaining_credits',
        'status',
        'transaction_id',
        'payment_method',
        'renewal_status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'renewal_status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->end_date > now();
    }

    public function hasCredits()
    {
        return $this->remaining_credits > 0;
    }

    public function useCredits($amount = 1)
    {
        if ($this->remaining_credits >= $amount) {
            $this->remaining_credits -= $amount;
            $this->save();
            return true;
        }
        return false;
    }
} 