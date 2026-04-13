<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(): View
    {
        $plans = Plan::withCount('companies')->orderBy('sort_order')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('admin.plans.form', ['plan' => new Plan()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:100'],
            'slug'                  => ['required', 'string', 'unique:plans,slug'],
            'description'           => ['nullable', 'string'],
            'price_monthly'         => ['required', 'integer', 'min:0'],
            'price_yearly'          => ['required', 'integer', 'min:0'],
            'max_jobs'              => ['nullable', 'integer', 'min:1'],
            'max_recruiters'        => ['required', 'integer', 'min:1'],
            'featured_jobs_allowed' => ['boolean'],
            'has_analytics'         => ['boolean'],
            'has_ats'               => ['boolean'],
            'sort_order'            => ['integer', 'min:0'],
        ]);

        $data['featured_jobs_allowed'] = $request->boolean('featured_jobs_allowed');
        $data['has_analytics']         = $request->boolean('has_analytics');
        $data['has_ats']               = $request->boolean('has_ats');
        $data['is_active']             = true;

        Plan::create($data);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan): View
    {
        return view('admin.plans.form', compact('plan'));
    }

    public function update(Request $request, Plan $plan): RedirectResponse
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:100'],
            'description'           => ['nullable', 'string'],
            'price_monthly'         => ['required', 'integer', 'min:0'],
            'price_yearly'          => ['required', 'integer', 'min:0'],
            'max_jobs'              => ['nullable', 'integer', 'min:1'],
            'max_recruiters'        => ['required', 'integer', 'min:1'],
            'featured_jobs_allowed' => ['nullable'],
            'has_analytics'         => ['nullable'],
            'has_ats'               => ['nullable'],
            'is_active'             => ['nullable'],
            'sort_order'            => ['integer', 'min:0'],
        ]);

        $data['featured_jobs_allowed'] = $request->boolean('featured_jobs_allowed');
        $data['has_analytics']         = $request->boolean('has_analytics');
        $data['has_ats']               = $request->boolean('has_ats');
        $data['is_active']             = $request->boolean('is_active');

        $plan->update($data);

        return redirect()->route('admin.plans.index')
            ->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan): RedirectResponse
    {
        if ($plan->companies()->count() > 0) {
            return back()->with('error',
                'Cannot delete plan — ' . $plan->companies()->count() . ' companies are using it.');
        }

        $plan->delete();
        return back()->with('success', 'Plan deleted.');
    }
}
