<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\SeekerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user    = auth()->user();
        $profile = $user->seekerProfile ?? new SeekerProfile();

        return view('seeker.profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request): RedirectResponse
{
    $user = auth()->user();

    $request->validate([
        'name'               => ['required', 'string', 'max:255'],
        'phone'              => ['nullable', 'string', 'max:20'],
        'avatar'             => ['nullable', 'image', 'max:2048'],
        'headline'           => ['nullable', 'string', 'max:255'],
        'summary'            => ['nullable', 'string', 'max:2000'],
        'location'           => ['nullable', 'string', 'max:100'],
        'experience_years'   => ['nullable', 'integer', 'min:0', 'max:50'],
        'current_salary'     => ['nullable', 'integer', 'min:0'],
        'expected_salary'    => ['nullable', 'integer', 'min:0'],
        'notice_period_days' => ['nullable', 'integer', 'min:0'],
        'availability'       => ['nullable', 'in:immediate,1_month,3_months,not_looking'],
        'linkedin_url'       => ['nullable', 'url', 'max:255'],
        'portfolio_url'      => ['nullable', 'url', 'max:255'],
        'github_url'         => ['nullable', 'url', 'max:255'],
        'skills'             => ['nullable', 'string'],
        'resume'             => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
    ]);

    // Handle avatar upload
    $avatarPath = $user->avatar;
    if ($request->hasFile('avatar')) {
        // Delete old avatar
        if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
            \Storage::disk('public')->delete($user->avatar);
        }
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
    }

    // Update user
    $user->update([
        'name'   => $request->name,
        'phone'  => $request->phone,
        'avatar' => $avatarPath,
    ]);

    // Parse skills
    $skills = [];
    if ($request->filled('skills')) {
        $skills = array_values(array_filter(
            array_map('trim', explode(',', $request->skills))
        ));
    }

    // Handle resume upload
    $resumePath = $user->seekerProfile?->resume_path;
    if ($request->hasFile('resume')) {
        $resumePath = $request->file('resume')->store('resumes', 'public');
    }

    SeekerProfile::updateOrCreate(
        ['user_id' => $user->id],
        [
            'headline'           => $request->headline,
            'summary'            => $request->summary,
            'location'           => $request->location,
            'experience_years'   => $request->experience_years ?? 0,
            'current_salary'     => $request->current_salary,
            'expected_salary'    => $request->expected_salary,
            'notice_period_days' => $request->notice_period_days ?? 30,
            'availability'       => $request->availability ?? 'immediate',
            'linkedin_url'       => $request->linkedin_url,
            'portfolio_url'      => $request->portfolio_url,
            'github_url'         => $request->github_url,
            'skills'             => $skills,
            'resume_path'        => $resumePath,
        ]
    );

    return back()->with('success', 'Profile updated successfully!');
}
}
