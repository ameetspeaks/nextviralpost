<?php

namespace App\Providers;

use App\Services\PDFExtractor;
use App\Services\LinkedInProfileAnalyzer;
use Illuminate\Support\ServiceProvider;

class PDFServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PDFExtractor::class, function ($app) {
            return new PDFExtractor();
        });

        $this->app->singleton(LinkedInProfileAnalyzer::class, function ($app) {
            return new LinkedInProfileAnalyzer($app->make(PDFExtractor::class));
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