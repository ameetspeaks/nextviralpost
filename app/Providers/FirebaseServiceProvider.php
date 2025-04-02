<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use GuzzleHttp\Client;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('firebase.auth', function ($app) {
            $httpClient = new Client([
                'verify' => false, // Disable SSL verification
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ]
            ]);

            $factory = (new Factory)
                ->withServiceAccount(config('firebase.credentials.file'))
                ->withDatabaseUri(config('firebase.database_url'));

            // Set the HTTP client using reflection since the method is not public
            $reflection = new \ReflectionProperty($factory, 'client');
            $reflection->setAccessible(true);
            $reflection->setValue($factory, $httpClient);

            return $factory->createAuth();
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