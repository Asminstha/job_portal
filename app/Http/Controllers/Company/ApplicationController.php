<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\NotificationService;

class ApplicationController extends Controller
{
    public function index(string $jobId): View
    {
        $company = auth()->user()->company;

        // 'all' shows every application for the company
        if ($jobId === 'all') {
            $job = null;
            $query = Application::with(['job', 'user', 'user.seekerProfile'])
                ->withoutGlobalScopes()
                ->where('company_id', $company->id);
        } else {
            $job = Job::withoutGlobalScopes()
                ->where('company_id', $company->id)
                ->findOrFail($jobId);

            $query = Application::with(['user', 'user.seekerProfile'])
                ->withoutGlobalScopes()
                ->where('company_id', $company->id)
                ->where('job_id', $job->id);
        }

        // Filter by status
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        $applications = $query->latest()->paginate(20)->withQueryString();

        // All company jobs for the filter dropdown
        $jobs = Job::withoutGlobalScopes()
            ->where('company_id', $company->id)
            ->orderByDesc('created_at')
            ->get();

        // Status counts for tabs
        $statusCounts = Application::withoutGlobalScopes()
            ->where('company_id', $company->id)
            ->when($job, fn($q) => $q->where('job_id', $job->id))
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('company.applications.index',
            compact('applications', 'job', 'jobs', 'statusCounts'));
    }

    public function show(string $jobId, string $applicationId): View
    {
        $application = Application::with([
                'job', 'user', 'user.seekerProfile',
                'statusHistories.changedBy', 'interviews'
            ])
            ->withoutGlobalScopes()
            ->where('company_id', auth()->user()->company_id)
            ->findOrFail($applicationId);

        // Mark as read
        if (! $application->read_at) {
            $application->update(['read_at' => now()]);
        }

        return view('company.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, string $applicationId): RedirectResponse
    {
        $application = Application::withoutGlobalScopes()
            ->where('company_id', auth()->user()->company_id)
            ->findOrFail($applicationId);

        $request->validate([
            'status' => ['required', 'in:pending,reviewed,shortlisted,interview,offered,hired,rejected,withdrawn'],
            'note'   => ['nullable', 'string', 'max:500'],
        ]);

        $oldStatus = $application->status;
        $newStatus = $request->status;

        $application->update([
            'status'            => $newStatus,
            'status_changed_at' => now(),
            'rejection_reason'  => $newStatus === 'rejected' ? $request->note : $application->rejection_reason,
        ]);

        // Record history
        ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'changed_by'     => auth()->id(),
            'from_status'    => $oldStatus,
            'to_status'      => $newStatus,
            'note'           => $request->note,
        ]);
        // Notify seeker of status change
        app(NotificationService::class)->applicationStatusChanged($application->fresh());


        return back()->with('success', 'Application status updated to ' . ucfirst($newStatus) . '.');
    }
}
