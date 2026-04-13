<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\Job;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_companies'    => Company::count(),
            'active_companies'   => Company::where('is_active', true)
                                        ->whereIn('subscription_status', ['trial','active'])->count(),
            'total_jobs'         => Job::withoutGlobalScopes()->count(),
            'active_jobs'        => Job::withoutGlobalScopes()->where('status','active')->count(),
            'total_users'        => User::where('role','seeker')->count(),
            'total_applications' => Application::withoutGlobalScopes()->count(),
            'trial_companies'    => Company::where('subscription_status','trial')->count(),
            'paid_companies'     => Company::where('subscription_status','active')->count(),
        ];

        // Revenue this month
        $revenueThisMonth = Subscription::where('status','active')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount_paid');

        $revenueTotal = Subscription::where('status','active')->sum('amount_paid');

        // Recent companies
        $recentCompanies = Company::with('plan')
            ->latest()
            ->take(8)
            ->get();

        // Recent subscriptions
        $recentSubscriptions = Subscription::with(['company','plan'])
            ->latest()
            ->take(5)
            ->get();

        // Monthly signups for chart (last 6 months)
        $monthlySignups = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = now()->subMonths($monthsAgo);
            return [
                'month'     => $date->format('M'),
                'companies' => Company::whereYear('created_at', $date->year)
                                  ->whereMonth('created_at', $date->month)->count(),
                'jobs'      => Job::withoutGlobalScopes()
                                  ->whereYear('created_at', $date->year)
                                  ->whereMonth('created_at', $date->month)->count(),
            ];
        });

        return view('admin.dashboard', compact(
            'stats', 'revenueThisMonth', 'revenueTotal',
            'recentCompanies', 'recentSubscriptions', 'monthlySignups'
        ));
    }
}
