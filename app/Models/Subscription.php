<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plan_type',
        'duration',
        'credits',
        'price',
        'billing_cycle',
        'discount_percentage',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function calculateYearlyPrice()
    {
        if ($this->billing_cycle === 'monthly') {
            return $this->price * 12 * (1 - ($this->discount_percentage / 100));
        }
        return $this->price;
    }
} 