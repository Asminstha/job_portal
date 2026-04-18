<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command
{
    protected $signature   = 'logs:clear';
    protected $description = 'Clear the laravel.log file';

    public function handle(): void
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {
            file_put_contents($logFile, '');
            $this->info('Log file cleared successfully.');
        } else {
            $this->comment('No log file to clear.');
        }
    }
}
