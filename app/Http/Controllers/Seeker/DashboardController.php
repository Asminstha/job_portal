<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\SavedJob;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'total_applications' => Application::where('user_id', $user->id)->count(),
            'pending'            => Application::where('user_id', $user->id)
                                        ->where('status', 'pending')->count(),
            'shortlisted'        => Application::where('user_id', $user->id)
                                        ->whereIn('status', ['shortlisted', 'interview'])->count(),
            'saved_jobs'         => SavedJob::where('user_id', $user->id)->count(),
        ];

        $recentApplications = Application::with(['job', 'job.company'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $savedJobs = SavedJob::with(['job', 'job.company', 'job.category'])
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->take(4)
            ->get();

        $profile         = $user->seekerProfile;
        $profileComplete = $this->profileCompleteness($user);

        return view('seeker.dashboard',
            compact('stats', 'recentApplications', 'savedJobs', 'profile', 'profileComplete'));
    }

    private function profileCompleteness($user): int
    {
        $profile = $user->seekerProfile;
        $score   = 0;
        $checks  = [
            $user->name,
            $user->email,
            $user->phone,
            $profile?->headline,
            $profile?->summary,
            $profile?->location,
            $profile?->resume_path,
            $profile?->skills && count($profile->skills) > 0,
            $profile?->experience_years,
            $profile?->linkedin_url,
        ];

        foreach ($checks as $check) {
            if ($check) $score++;
        }

        return (int) round(($score / count($checks)) * 100);
    }
}
