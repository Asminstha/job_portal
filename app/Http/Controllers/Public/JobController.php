<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\SavedJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\NotificationService;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::with(['company', 'category'])
            ->withoutGlobalScopes()
            ->where('status', 'active')
            ->where(fn($q) => $q
                ->whereNull('expires_at')
                ->orWhere('expires_at', '>', now())
            );

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn($b) => $b
                ->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('company', fn($c) =>
                    $c->where('name', 'like', "%{$search}%")
                )
            );
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($c) =>
                $c->where('slug', $request->category)
            );
        }

        if ($request->filled('location')) {
            $loc = $request->location;
            $query->where(fn($b) => $b
                ->where('city', 'like', "%{$loc}%")
                ->orWhere('location_type', 'remote')
            );
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('location_type')) {
            $query->where('location_type', $request->location_type);
        }

        if ($request->filled('experience')) {
            $query->where('experience_min', '<=', $request->experience);
        }

        match($request->get('sort', 'latest')) {
            'salary_high' => $query->orderByDesc('salary_max'),
            'salary_low'  => $query->orderBy('salary_min'),
            default       => $query->orderByDesc('is_featured')
                                   ->orderByDesc('published_at'),
        };

        $jobs       = $query->paginate(15)->withQueryString();
        $categories = JobCategory::where('is_active', true)
                        ->orderBy('sort_order')->get();

        $savedJobIds = [];
        if (auth()->check() && auth()->user()->isSeeker()) {
            $savedJobIds = SavedJob::where('user_id', auth()->id())
                ->pluck('job_id')->toArray();
        }

        return view('public.jobs.index', compact('jobs', 'categories', 'savedJobIds'));
    }

    public function show(string $slug): View
    {
        $job = Job::with(['company', 'category'])
            ->withoutGlobalScopes()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $job->increment('views_count');

        $hasApplied = false;
        $isSaved    = false;

        if (auth()->check() && auth()->user()->isSeeker()) {
            $hasApplied = Application::where('job_id', $job->id)
                ->where('user_id', auth()->id())
                ->exists();

            $isSaved = SavedJob::where('job_id', $job->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        $relatedJobs = Job::with('company')
            ->withoutGlobalScopes()
            ->where('status', 'active')
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->take(4)
            ->get();

        return view('public.jobs.show', compact('job', 'hasApplied', 'isSaved', 'relatedJobs'));
    }

    public function apply(Request $request, string $slug): RedirectResponse
    {
        $job = Job::withoutGlobalScopes()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $user = auth()->user();

        if (! $user->isSeeker()) {
            return back()->with('error', 'Only job seekers can apply for jobs.');
        }

        $alreadyApplied = Application::where('job_id', $job->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $request->validate([
            'cover_letter' => ['nullable', 'string', 'max:3000'],
            'resume'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'job_id'       => $job->id,
            'user_id'      => $user->id,
            'company_id'   => $job->company_id,
            'cover_letter' => $request->cover_letter,
            'resume_path'  => $resumePath,
            'status'       => 'pending',
        ]);

        $job->increment('applications_count');
// Send notification to company
app(NotificationService::class)->applicationReceived(
    Application::where('job_id', $job->id)
        ->where('user_id', $user->id)
        ->latest()
        ->first()
);

return back()->with('success', 'Application submitted successfully! Good luck!');
    }
}
