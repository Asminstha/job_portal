<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\View\View;

class HomeController extends Controller
{
    // public function index(): View
    // {
    //     $categories = JobCategory::withCount(['jobs' => function ($q) {
    //             $q->where('status', 'active');
    //         }])
    //         ->where('is_active', true)
    //         ->orderByDesc('jobs_count')
    //         ->take(12)
    //         ->get();

    //     $latestJobs = Job::with(['company', 'category'])
    //         ->where('status', 'active')
    //         ->latest('published_at')
    //         ->take(8)
    //         ->get();

    //     return view('public.home', compact('categories', 'latestJobs'));
    // }

    public function index(): View
{
    $categories = collect([]); // Will be real data after Phase 2
    $latestJobs = collect([]);
    return view('public.home', compact('categories', 'latestJobs'));
}
}
