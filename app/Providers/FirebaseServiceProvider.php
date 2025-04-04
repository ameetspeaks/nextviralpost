<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Firebase\CustomFirebaseFactory;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('firebase.auth', function ($app) {
            return CustomFirebaseFactory::createAuth(
                config('firebase.credentials.file'),
                config('firebase.project_id')
            );
        });

        $this->app->singleton('firebase.database', function ($app) {
            return CustomFirebaseFactory::createDatabase(
                config('firebase.credentials.file'),
                config('firebase.project_id')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 