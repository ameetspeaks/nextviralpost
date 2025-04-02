<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CustomServeCommand extends Command
{
    protected $signature = 'serve:custom {--port=8000}';
    protected $description = 'Start the Laravel development server with Windows compatibility';

    public function handle()
    {
        $port = $this->option('port');
        $this->info("Starting Laravel development server on http://127.0.0.1:{$port}");
        
        $process = new Process(['php', '-S', "127.0.0.1:{$port}", '-t', 'public']);
        $process->setTimeout(0);
        
        try {
            $process->run(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    $this->error($buffer);
                } else {
                    $this->line($buffer);
                }
            });
        } catch (ProcessFailedException $e) {
            $this->error($e->getMessage());
        }
    }
} 