<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::with(['company', 'category'])
            ->withoutGlobalScopes()
            ->withCount([
                'applications' => fn($q) => $q->withoutGlobalScopes()
            ]);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(fn($b) => $b
                ->where('title', 'like', "%{$search}%")
                ->orWhereHas('company', fn($c) => $c->where('name', 'like', "%{$search}%"))
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query->latest()->paginate(20)->withQueryString();

        return view('admin.jobs.index', compact('jobs'));
    }

    public function toggle(string $id): RedirectResponse
    {
        $job = Job::withoutGlobalScopes()->findOrFail($id);
        $newStatus = $job->status === 'active' ? 'paused' : 'active';
        $job->update(['status' => $newStatus]);

        return back()->with('success', "Job status changed to {$newStatus}.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $job = Job::withoutGlobalScopes()->findOrFail($id);
        $job->delete();

        return back()->with('success', 'Job deleted successfully.');
    }
}
