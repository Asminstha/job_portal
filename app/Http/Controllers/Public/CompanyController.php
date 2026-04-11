<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $query = Company::withCount([
                'jobs' => fn($q) => $q
                    ->withoutGlobalScopes()
                    ->where('status', 'active')
            ])
            ->where('is_active', true)
            ->whereIn('subscription_status', ['trial', 'active']);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn($b) => $b
                ->where('name', 'like', "%{$search}%")
                ->orWhere('industry', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
            );
        }

        if ($request->filled('industry')) {
            $query->where('industry', $request->industry);
        }

        $companies = $query->orderByDesc('jobs_count')
            ->paginate(16)
            ->withQueryString();

        $industries = Company::where('is_active', true)
            ->whereNotNull('industry')
            ->distinct()
            ->pluck('industry')
            ->sort()
            ->values();

        return view('public.companies.index', compact('companies', 'industries'));
    }

    public function show(string $slug): View
    {
        $company = Company::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $jobs = Job::with('category')
            ->withoutGlobalScopes()
            ->where('company_id', $company->id)
            ->where('status', 'active')
            ->where(fn($q) => $q
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>', now())
            )
            ->latest('published_at')
            ->paginate(10);

        return view('public.companies.show', compact('company', 'jobs'));
    }
}
