<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadCACert extends Command
{
    protected $signature = 'app:download-cacert';
    protected $description = 'Download the latest CA certificate bundle';

    public function handle()
    {
        $this->info('Downloading CA certificate bundle...');

        $certUrl = 'https://curl.se/ca/cacert.pem';
        $certPath = storage_path('app/cacert.pem');

        try {
            $certContent = file_get_contents($certUrl);
            if ($certContent === false) {
                throw new \Exception('Failed to download certificate bundle');
            }

            if (!file_put_contents($certPath, $certContent)) {
                throw new \Exception('Failed to save certificate bundle');
            }

            $this->info('CA certificate bundle downloaded successfully to: ' . $certPath);
        } catch (\Exception $e) {
            $this->error('Error downloading CA certificate bundle: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
} 