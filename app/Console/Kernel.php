<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\DownloadCACert::class,
        Commands\CheckSubscriptionExpiry::class,
        Commands\AssignAdminPlan::class,
        Commands\TestCreditDeduction::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('subscriptions:check-expired')
            ->daily()
            ->at('00:00');

        // Check subscription expiry daily
        $schedule->command('subscriptions:check-expiry')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 