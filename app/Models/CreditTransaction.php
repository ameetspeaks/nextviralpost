<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_subscription_id',
        'amount',
        'balance',
        'type',
        'description',
        'post_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userSubscription()
    {
        return $this->belongsTo(UserSubscription::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function createTransaction(UserSubscription $subscription, $amount, $type, $description, $postId = null)
    {
        return static::create([
            'user_id' => $subscription->user_id,
            'user_subscription_id' => $subscription->id,
            'amount' => $amount,
            'balance' => $subscription->remaining_credits,
            'type' => $type,
            'description' => $description,
            'post_id' => $postId
        ]);
    }
} 