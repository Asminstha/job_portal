<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReadLogs extends Command
{
    protected $signature   = 'logs:read {--type=all : Filter by type: mail, error, all}';
    protected $description = 'Read laravel.log in a clean readable format';

    public function handle(): void
    {
        $logFile = storage_path('logs/laravel.log');

        if (! file_exists($logFile)) {
            $this->error('No log file found.');
            return;
        }

        $content = file_get_contents($logFile);
        $lines   = explode("\n", $content);

        $type    = $this->option('type');
        $entries = [];
        $current = '';

        foreach ($lines as $line) {
            if (preg_match('/^\[\d{4}-\d{2}-\d{2}/', $line)) {
                if ($current) $entries[] = $current;
                $current = $line;
            } else {
                $current .= "\n" . $line;
            }
        }
        if ($current) $entries[] = $current;

        // Take last 20 entries
        $entries = array_slice($entries, -20);

        foreach ($entries as $entry) {
            // Filter by type
            if ($type === 'mail' && ! str_contains($entry, 'Subject:') && ! str_contains($entry, 'To:') && ! str_contains($entry, 'MIME')) {
                continue;
            }
            if ($type === 'error' && ! str_contains($entry, 'ERROR') && ! str_contains($entry, 'Exception')) {
                continue;
            }

            // Determine entry type and color
            if (str_contains($entry, 'ERROR') || str_contains($entry, 'Exception')) {
                $this->error('──────────────────────────────────────');
                $this->error(substr($entry, 0, 500));
            } elseif (str_contains($entry, 'Subject:') || str_contains($entry, 'MIME-Version')) {
                $this->info('──── EMAIL ────────────────────────────');
                // Extract key email info only
                foreach (explode("\n", $entry) as $line) {
                    if (
                        str_contains($line, 'Subject:') ||
                        str_contains($line, 'To:') ||
                        str_contains($line, 'From:')
                    ) {
                        $this->line('  ' . trim($line));
                    }
                }
            } else {
                $this->line(substr($entry, 0, 200));
            }
        }

        $this->newLine();
        $this->comment('Showing last ' . count($entries) . ' log entries.');
        $this->comment('Use --type=mail for emails only, --type=error for errors only.');
    }
}
