@extends('layouts.app')
@section('title', 'Application — ' . $application->user->name)
@section('page-title', $application->user->name)
@section('page-subtitle', 'Applied for: ' . $application->job->title)

@section('content')

<div class="flex flex-col lg:flex-row gap-6">

    {{-- Left: candidate info --}}
    <div class="flex-1 space-y-5">

        {{-- Candidate card --}}
        <div class="card p-6">
            <div class="flex items-start gap-5">
                <div class="w-16 h-16 rounded-full bg-brand-100 dark:bg-brand-900
                            flex items-center justify-center
                            text-brand-700 dark:text-brand-300 text-2xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $application->user->name }}
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $application->user->email }}</p>
                    @if($application->user->phone)
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $application->user->phone }}</p>
                    @endif

                    @if($profile = $application->user->seekerProfile)
                        @if($profile->headline)
                            <p class="mt-2 text-brand-600 dark:text-brand-400 font-medium text-sm">
                                {{ $profile->headline }}
                            </p>
                        @endif
                        <div class="flex flex-wrap gap-3 mt-3 text-xs text-gray-500 dark:text-gray-400">
                            @if($profile->location)
                                <span>📍 {{ $profile->location }}</span>
                            @endif
                            @if($profile->experience_years)
                                <span>💼 {{ $profile->experience_years }} years experience</span>
                            @endif
                            @if($profile->expected_salary)
                                <span>💰 Expected: NPR {{ number_format($profile->expected_salary) }}/mo</span>
                            @endif
                            @if($profile->availability)
                                <span>🗓 {{ ucfirst(str_replace('_',' ',$profile->availability)) }}</span>
                            @endif
                        </div>

                        @if($profile->skills && count($profile->skills))
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @foreach($profile->skills as $skill)
                                    <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800
                                                 text-gray-700 dark:text-gray-300 rounded-lg text-xs">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if($profile->summary)
                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $profile->summary }}
                            </p>
                        @endif

                        {{-- Links --}}
                        <div class="flex flex-wrap gap-3 mt-3">
                            @if($profile->linkedin_url)
                                <a href="{{ $profile->linkedin_url }}" target="_blank"
                                   class="text-xs text-blue-600 hover:underline">LinkedIn</a>
                            @endif
                            @if($profile->portfolio_url)
                                <a href="{{ $profile->portfolio_url }}" target="_blank"
                                   class="text-xs text-brand-600 hover:underline">Portfolio</a>
                            @endif
                            @if($profile->github_url)
                                <a href="{{ $profile->github_url }}" target="_blank"
                                   class="text-xs text-gray-600 hover:underline">GitHub</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Cover Letter --}}
        @if($application->cover_letter)
        <div class="card p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Cover Letter</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                {{ $application->cover_letter }}
            </p>
        </div>
        @endif

        {{-- Resume --}}
        @php $resumePath = $application->resume_path ?? $application->user->seekerProfile?->resume_path; @endphp
        @if($resumePath)
        <div class="card p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Resume / CV</h3>
            <a href="{{ asset('storage/' . $resumePath) }}" target="_blank"
               class="btn-secondary inline-flex">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0
                             012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0
                             01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Resume
            </a>
        </div>
        @endif

        {{-- Status history --}}
        @if($application->statusHistories->isNotEmpty())
        <div class="card p-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Activity Timeline</h3>
            <div class="space-y-4">
                @foreach($application->statusHistories->sortByDesc('created_at') as $history)
                <div class="flex gap-3">
                    <div class="w-2 h-2 rounded-full bg-brand-500 mt-1.5 flex-shrink-0"></div>
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Status changed from
                            <span class="font-medium">{{ ucfirst($history->from_status ?? 'new') }}</span>
                            to
                            <span class="font-medium text-brand-600 dark:text-brand-400">
                                {{ ucfirst($history->to_status) }}
                            </span>
                            by {{ $history->changedBy->name ?? 'System' }}
                        </p>
                        @if($history->note)
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                Note: {{ $history->note }}
                            </p>
                        @endif
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $history->created_at->format('M d, Y \a\t h:i A') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- Right: actions --}}
    <div class="w-full lg:w-72 flex-shrink-0">
        <div class="sticky top-24 space-y-5">

            {{-- Current status --}}
            <div class="card p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Application Status</h3>
                <div class="mb-4">
                    <span class="{{ $application->statusBadgeClass() }} text-sm px-3 py-1">
                        {{ $application->statusLabel() }}
                    </span>
                </div>

                <form method="POST"
                      action="{{ route('company.applications.status', $application->id) }}"
                      class="space-y-3">
                    @csrf @method('PATCH')
                    <div>
                        <label class="form-label">Update Status</label>
                        <select name="status" class="form-input">
                            @foreach(['pending','reviewed','shortlisted','interview','offered','hired','rejected','withdrawn'] as $s)
                                <option value="{{ $s }}" {{ $application->status === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Add Note (optional)</label>
                        <textarea name="note" rows="3" class="form-input resize-none text-sm"
                                  placeholder="Internal note visible only to your team..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">
                        Update Status
                    </button>
                </form>
            </div>

            {{-- Application info --}}
            <div class="card p-5">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Applied</span>
                        <span class="text-gray-900 dark:text-white font-medium">
                            {{ $application->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Job</span>
                        <a href="{{ route('jobs.show', $application->job->slug) }}"
                           class="text-brand-600 dark:text-brand-400 hover:underline font-medium text-right max-w-[140px] truncate"
                           target="_blank">
                            {{ $application->job->title }}
                        </a>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 dark:text-gray-400">Last updated</span>
                        <span class="text-gray-900 dark:text-white font-medium">
                            {{ optional($application->status_changed_at ?? $application->updated_at)->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <a href="{{ route('company.applications.index', $application->job_id) }}"
               class="btn-secondary w-full justify-center">
                ← Back to Applications
            </a>
        </div>
    </div>
</div>

@endsection
