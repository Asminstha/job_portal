<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = JobCategory::withCount([
                'jobs' => fn($q) => $q->where('job_postings.status', 'active')
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        $latestJobs = Job::with(['company', 'category'])
            ->withoutGlobalScopes()
            ->where('status', 'active')
            ->where(fn($q) => $q
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>', now())
            )
            ->latest('published_at')
            ->take(8)
            ->get();

        $totalJobs      = Job::withoutGlobalScopes()->where('status', 'active')->count();
        $totalCompanies = Company::where('is_active', true)->count();

        return view('public.home', compact(
            'categories', 'latestJobs', 'totalJobs', 'totalCompanies'
        ));
    }
}
