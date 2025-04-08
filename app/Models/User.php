<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasTrialSubscription;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable, HasTrialSubscription;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_superadmin',
        'email_verified_at',
        'facebook_token',
        'facebook_refresh_token',
        'facebook_expires_in',
        'twitter_token',
        'twitter_refresh_token',
        'twitter_expires_in',
        'linkedin_token',
        'linkedin_refresh_token',
        'linkedin_expires_in',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_superadmin' => 'boolean',
        'is_profile_complete' => 'boolean',
        'facebook_expires_in' => 'integer',
        'twitter_expires_in' => 'integer',
        'linkedin_expires_in' => 'integer',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_profile_complete' => 'boolean',
            'is_superadmin' => 'boolean',
            'facebook_expires_in' => 'integer',
            'twitter_expires_in' => 'integer',
            'linkedin_expires_in' => 'integer',
        ];
    }

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the bookmarks for the user.
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Get the feedback for the user.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function hasSocialMediaConnection($provider)
    {
        return !empty($this->{$provider . '_token'});
    }

    public function getSocialMediaToken($provider)
    {
        return $this->{$provider . '_token'};
    }

    public function getSocialMediaRefreshToken($provider)
    {
        return $this->{$provider . '_refresh_token'};
    }

    public function getSocialMediaExpiresIn($provider)
    {
        return $this->{$provider . '_expires_in'};
    }

    public function preference(): HasOne
    {
        return $this->hasOne(UserPreference::class);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'user_interests')
            ->withTimestamps();
    }

    public function hasCompletedOnboarding(): bool
    {
        return $this->preference && $this->preference->onboarding_completed;
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->latest();
    }

    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }

    public function hasActiveSubscription()
    {
        return $this->activeSubscription()->exists();
    }

    public function hasCredits()
    {
        return $this->activeSubscription?->hasCredits() ?? false;
    }

    public function useCredits($amount = 1)
    {
        if ($this->hasActiveSubscription()) {
            return $this->activeSubscription->useCredits($amount);
        }
        return false;
    }

    public function hasUsedFreeTrial()
    {
        return $this->userSubscriptions()
            ->whereHas('subscription', function ($query) {
                $query->where('plan_type', 'trial');
            })
            ->exists();
    }
}
