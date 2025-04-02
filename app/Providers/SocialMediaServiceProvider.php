<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;

class SocialMediaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Facebook
        Socialite::extend('facebook', function ($app) {
            return Socialite::buildProvider(
                \Laravel\Socialite\Two\FacebookProvider::class,
                [
                    'client_id' => config('services.facebook.client_id'),
                    'client_secret' => config('services.facebook.client_secret'),
                    'redirect' => config('services.facebook.redirect'),
                ]
            );
        });

        // Twitter
        Socialite::extend('twitter', function ($app) {
            return Socialite::buildProvider(
                \Laravel\Socialite\Two\TwitterProvider::class,
                [
                    'client_id' => config('services.twitter.client_id'),
                    'client_secret' => config('services.twitter.client_secret'),
                    'redirect' => config('services.twitter.redirect'),
                ]
            );
        });

        // LinkedIn
        Socialite::extend('linkedin', function ($app) {
            return Socialite::buildProvider(
                \Laravel\Socialite\Two\LinkedInProvider::class,
                [
                    'client_id' => config('services.linkedin.client_id'),
                    'client_secret' => config('services.linkedin.client_secret'),
                    'redirect' => config('services.linkedin.redirect'),
                ]
            );
        });
    }
} 