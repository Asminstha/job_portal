<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SavedJobController extends Controller
{
    public function index(): View
    {
        $savedJobs = SavedJob::with(['job', 'job.company', 'job.category'])
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->paginate(15);

        return view('seeker.saved.index', compact('savedJobs'));
    }

    public function toggle(string $jobId): RedirectResponse
    {
        $job = Job::withoutGlobalScopes()->findOrFail($jobId);

        $existing = SavedJob::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Job removed from saved jobs.');
        }

        SavedJob::create([
            'user_id' => auth()->id(),
            'job_id'  => $job->id,
        ]);

        return back()->with('success', 'Job saved! Find it in your saved jobs.');
    }
}
