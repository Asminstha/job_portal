<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Company::with(['plan'])
            ->withCount([
                'jobs'  => fn($q) => $q->withoutGlobalScopes(),
                'users',
            ]);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn($b) => $b
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('industry', 'like', "%{$search}%")
            );
        }

        if ($request->filled('status')) {
            $query->where('subscription_status', $request->status);
        }

        if ($request->filled('active')) {
            $query->where('is_active', $request->active === '1');
        }

        $companies = $query->latest()->paginate(20)->withQueryString();
        $plans     = Plan::where('is_active', true)->get();

        return view('admin.companies.index', compact('companies', 'plans'));
    }

    public function show(string $id): View
    {
        $company = Company::with(['plan', 'users', 'subscriptions.plan'])
            ->findOrFail($id);

        $stats = [
            'total_jobs'   => $company->jobs()->withoutGlobalScopes()->count(),
            'active_jobs'  => $company->jobs()->withoutGlobalScopes()
                                ->where('status', 'active')->count(),
            'applications' => \App\Models\Application::withoutGlobalScopes()
                                ->where('company_id', $company->id)->count(),
        ];

        $recentJobs = $company->jobs()
            ->withoutGlobalScopes()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.companies.show',
            compact('company', 'stats', 'recentJobs'));
    }

    public function toggle(string $id): RedirectResponse
    {
        $company = Company::findOrFail($id);
        $company->update(['is_active' => ! $company->is_active]);

        $status = $company->is_active ? 'activated' : 'suspended';
        return back()->with('success',
            "Company {$company->name} has been {$status}.");
    }

    public function changePlan(Request $request, string $id): RedirectResponse
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $company->update([
            'plan_id'             => $plan->id,
            'subscription_status' => 'active',
        ]);

        return back()->with('success',
            "Plan changed to {$plan->name} for {$company->name}.");
    }
}
