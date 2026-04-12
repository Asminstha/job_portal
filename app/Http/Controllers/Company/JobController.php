<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(): View
    {
        $jobs = Job::withoutGlobalScopes()
            ->where('company_id', auth()->user()->company_id)
            ->withCount(['applications' => fn($q) => $q->withoutGlobalScopes()])
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('company.jobs.index', compact('jobs'));
    }

    public function create(): View
    {
        $categories = JobCategory::where('is_active', true)
            ->orderBy('sort_order')->get();

        return view('company.jobs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'category_id'   => ['nullable', 'exists:job_categories,id'],
            'description'   => ['required', 'string', 'min:50'],
            'requirements'  => ['nullable', 'string'],
            'benefits'      => ['nullable', 'string'],
            'type'          => ['required', 'in:full_time,part_time,contract,internship,freelance'],
            'location_type' => ['required', 'in:remote,onsite,hybrid'],
            'city'          => ['nullable', 'string', 'max:100'],
            'country'       => ['nullable', 'string', 'max:100'],
            'salary_min'    => ['nullable', 'integer', 'min:0'],
            'salary_max'    => ['nullable', 'integer', 'min:0'],
            'salary_currency'=> ['nullable', 'string', 'max:10'],
            'salary_period' => ['nullable', 'in:monthly,yearly,hourly'],
            'salary_hidden' => ['nullable', 'boolean'],
            'experience_min'=> ['nullable', 'integer', 'min:0'],
            'experience_max'=> ['nullable', 'integer', 'min:0'],
            'expires_at'    => ['nullable', 'date', 'after:today'],
            'status'        => ['required', 'in:draft,active'],
        ]);

        $data['company_id']  = auth()->user()->company_id;
        $data['created_by']  = auth()->id();
        $data['salary_hidden'] = $request->boolean('salary_hidden');

        if ($data['status'] === 'active') {
            $data['published_at'] = now();
        }

        Job::create($data);

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job posted successfully!');
    }

    public function edit(string $id): View
    {
        $job = Job::withoutGlobalScopes()
            ->where('company_id', auth()->user()->company_id)
            ->findOrFail($id);

        $categories = JobCategory::where('is_active', true)
            ->orderBy('sort_order')->get();

        return view('company.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $job = Job::withoutGlobalScopes()
            ->where('company_id', auth()->user()->company_id)
            ->findOrFail($id);

        $data = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'category_id'    => ['nullable', 'exists:job_categories,id'],
            'description'    => ['required', 'string', 'min:50'],
            'requirements'   => ['nullable', 'string'],
            'benefits'       => ['nullable', 'string'],
            'type'           => ['required', 'in:full_time,part_time,contract,internship,freelance'],
            'location_type'  => ['required', 'in:remote,onsite,hybrid'],
            'city'           => ['nullable', 'string', 'max:100'],
            'country'        => ['nullable', 'string', 'max:100'],
            'salary_min'     => ['nullable', 'integer', 'min:0'],
            'salary_max'     => ['nullable', 'integer', 'min:0'],
            'salary_currency'=> ['nullable', 'string', 'max:10'],
            'salary_period'  => ['nullable', 'in:monthly,yearly,hourly'],
            'salary_hidden'  => ['nullable', 'boolean'],
            'experience_min' => ['nullable', 'integer', 'min:0'],
            'experience_max' => ['nullable', 'integer', 'min:0'],
            'expires_at'     => ['nullable', 'date'],
            'status'         => ['required', 'in:draft,active,paused,closed'],
        ]);

        $data['salary_hidden'] = $request->boolean('salary_hidden');

        if ($data['status'] === 'active' && ! $job->published_at) {
            $data['published_at'] = now();
        }

        $job->update($data);

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $job = Job::withoutGlobalScopes()
            ->where('company_id', auth()->user()->company_id)
            ->findOrFail($id);

        $job->delete();

        return redirect()->route('company.jobs.index')
            ->with('success', 'Job deleted.');
    }

    public function toggleStatus(Request $request, string $id): RedirectResponse
    {
        $job = Job::withoutGlobalScopes()
            ->where('company_id', auth()->user()->company_id)
            ->findOrFail($id);

        $newStatus = $job->status === 'active' ? 'paused' : 'active';

        if ($newStatus === 'active' && ! $job->published_at) {
            $job->published_at = now();
        }

        $job->update(['status' => $newStatus]);

        return back()->with('success', 'Job status updated to ' . $newStatus . '.');
    }
}
