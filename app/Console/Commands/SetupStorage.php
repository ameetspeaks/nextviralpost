<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetupStorage extends Command
{
    protected $signature = 'setup:storage';
    protected $description = 'Set up storage directories and permissions';

    public function handle()
    {
        $this->info('Setting up storage directories...');

        // Create necessary directories
        $directories = [
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
            storage_path('app/public'),
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("Created directory: {$directory}");
            }
        }

        // Create .gitignore files
        $gitignoreContent = "*\n!.gitignore\n";
        foreach ($directories as $directory) {
            $gitignoreFile = $directory . '/.gitignore';
            if (!File::exists($gitignoreFile)) {
                File::put($gitignoreFile, $gitignoreContent);
                $this->info("Created .gitignore in: {$directory}");
            }
        }

        // Create symbolic link for public storage
        if (!File::exists(public_path('storage'))) {
            $this->call('storage:link');
            $this->info('Created storage symbolic link');
        }

        $this->info('Storage setup completed successfully!');
    }
} 