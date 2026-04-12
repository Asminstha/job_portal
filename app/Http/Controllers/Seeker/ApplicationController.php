<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $applications = Application::with(['job', 'job.company', 'job.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        $statusCounts = Application::where('user_id', auth()->id())
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('seeker.applications.index',
            compact('applications', 'statusCounts'));
    }

    public function withdraw(string $id): RedirectResponse
    {
        $application = Application::where('user_id', auth()->id())
            ->findOrFail($id);

        if (in_array($application->status, ['hired', 'rejected'])) {
            return back()->with('error', 'This application cannot be withdrawn.');
        }

        $application->update([
            'status'            => 'withdrawn',
            'status_changed_at' => now(),
        ]);

        return back()->with('success', 'Application withdrawn successfully.');
    }
}
