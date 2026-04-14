<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $company = auth()->user()->company;

        $stats = [
            'total_jobs'         => Job::withoutGlobalScopes()
                                       ->where('company_id', $company->id)->count(),
            'active_jobs'        => Job::withoutGlobalScopes()
                                       ->where('company_id', $company->id)
                                       ->where('status', 'active')->count(),
            'total_applications' => Application::withoutGlobalScopes()
                                       ->where('company_id', $company->id)->count(),
            'new_applications'   => Application::withoutGlobalScopes()
                                       ->where('company_id', $company->id)
                                       ->where('status', 'pending')->count(),
            'shortlisted'        => Application::withoutGlobalScopes()
                                       ->where('company_id', $company->id)
                                       ->where('status', 'shortlisted')->count(),
            'hired'              => Application::withoutGlobalScopes()
                                       ->where('company_id', $company->id)
                                       ->where('status', 'hired')->count(),
        ];

        $recentApplications = Application::with(['job', 'user.seekerProfile'])
            ->withoutGlobalScopes()
            ->where('company_id', $company->id)
            ->latest()
            ->take(8)
            ->get();

        $activeJobs = Job::withoutGlobalScopes()
            ->where('company_id', $company->id)
            ->where('status', 'active')
            ->withCount(['applications' => fn($q) => $q->withoutGlobalScopes()])
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        return view('company.dashboard', compact('stats', 'recentApplications', 'activeJobs', 'company'));
    }
}
