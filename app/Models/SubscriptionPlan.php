<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'credits_per_month',
        'max_posts_per_day',
        'has_viral_recipe',
        'has_analytics',
        'has_priority_support',
        'badge_color',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'credits_per_month' => 'integer',
        'max_posts_per_day' => 'integer',
        'has_viral_recipe' => 'boolean',
        'has_analytics' => 'boolean',
        'has_priority_support' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->userSubscriptions()
            ->where('ends_at', '>', now())
            ->orWhereNull('ends_at');
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getBadgeClassesAttribute()
    {
        $baseClasses = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium';
        
        return match($this->badge_color) {
            'red' => $baseClasses . ' bg-red-100 text-red-800',
            'yellow' => $baseClasses . ' bg-yellow-100 text-yellow-800',
            'green' => $baseClasses . ' bg-green-100 text-green-800',
            'blue' => $baseClasses . ' bg-blue-100 text-blue-800',
            'indigo' => $baseClasses . ' bg-indigo-100 text-indigo-800',
            'purple' => $baseClasses . ' bg-purple-100 text-purple-800',
            'pink' => $baseClasses . ' bg-pink-100 text-pink-800',
            default => $baseClasses . ' bg-gray-100 text-gray-800',
        };
    }
}
