<?php

namespace App\Console\Commands;

use App\Mail\TrialExpiringSoonMail;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTrialReminders extends Command
{
    protected $signature   = 'app:send-trial-reminders';
    protected $description = 'Send email reminders to companies whose trial is expiring soon';

    public function handle(): void
    {
        // Send reminders at 7 days and 2 days before expiry
        foreach ([7, 2] as $days) {
            $companies = Company::where('subscription_status', 'trial')
                ->where('is_active', true)
                ->whereDate('trial_ends_at', now()->addDays($days)->toDateString())
                ->get();

            foreach ($companies as $company) {
                $admin = $company->users()
                    ->where('role', 'company_admin')
                    ->first();

                if ($admin) {
                    Mail::to($admin->email)
                        ->queue(new TrialExpiringSoonMail($company, $days));

                    $this->info("Sent {$days}-day reminder to {$company->name}");
                }
            }
        }

        $this->info('Trial reminders sent successfully.');
    }
}
