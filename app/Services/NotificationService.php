<?php

namespace App\Services;

use App\Mail\ApplicationReceivedMail;
use App\Mail\ApplicationStatusChangedMail;
use App\Mail\NewCompanyRegisteredMail;
use App\Mail\SubscriptionActivatedMail;
use App\Models\Application;
use App\Models\Company;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    // Called when seeker applies to a job
    public function applicationReceived(Application $application): void
    {
        try {
            // Notify all company admins and recruiters
            $recipients = User::where('company_id', $application->company_id)
                ->whereIn('role', ['company_admin', 'recruiter'])
                ->where('is_active', true)
                ->get();

            foreach ($recipients as $recipient) {
                Mail::to($recipient->email)
                    ->queue(new ApplicationReceivedMail($application));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send application received email: ' . $e->getMessage());
        }
    }

    // Called when HR updates application status
    public function applicationStatusChanged(Application $application): void
    {
        try {
            Mail::to($application->user->email)
                ->queue(new ApplicationStatusChangedMail($application));
        } catch (\Exception $e) {
            \Log::error('Failed to send status changed email: ' . $e->getMessage());
        }
    }

    // Called when new company registers
    public function newCompanyRegistered(Company $company): void
    {
        try {
            $adminEmail = config('mail.admin_email', 'admin@jobsnepal.com');
            Mail::to($adminEmail)
                ->queue(new NewCompanyRegisteredMail($company));
        } catch (\Exception $e) {
            \Log::error('Failed to send new company email: ' . $e->getMessage());
        }
    }

    // Called when admin approves subscription
    public function subscriptionActivated(Subscription $subscription): void
    {
        try {
            $companyAdmin = User::where('company_id', $subscription->company_id)
                ->where('role', 'company_admin')
                ->first();

            if ($companyAdmin) {
                Mail::to($companyAdmin->email)
                    ->queue(new SubscriptionActivatedMail($subscription));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send subscription activated email: ' . $e->getMessage());
        }
    }
}
