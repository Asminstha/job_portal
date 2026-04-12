@extends('layouts.seeker')
@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('content')

{{-- Profile completeness banner --}}
@if($profileComplete < 80)
<div class="mb-6 p-4 bg-brand-50 dark:bg-brand-900/30
            border border-brand-200 dark:border-brand-700 rounded-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <p class="text-sm font-medium text-brand-800 dark:text-brand-200">
                Complete your profile to get noticed by employers
            </p>
            <div class="flex items-center gap-3 mt-2">
                <div class="flex-1 max-w-xs bg-brand-200 dark:bg-brand-800 rounded-full h-2">
                    <div class="bg-brand-600 h-2 rounded-full transition-all duration-500"
                         style="width: {{ $profileComplete }}%"></div>
                </div>
                <span class="text-sm font-semibold text-brand-700 dark:text-brand-300">
                    {{ $profileComplete }}% complete
                </span>
            </div>
        </div>
        <a href="{{ route('seeker.profile.edit') }}" class="btn-primary text-sm whitespace-nowrap">
            Complete Profile
        </a>
    </div>
</div>
@endif

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['label' => 'Total Applications', 'value' => $stats['total_applications'], 'color' => 'blue',   'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['label' => 'Pending Review',     'value' => $stats['pending'],            'color' => 'yellow', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Shortlisted',        'value' => $stats['shortlisted'],        'color' => 'green',  'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
        ['label' => 'Saved Jobs',         'value' => $stats['saved_jobs'],         'color' => 'purple', 'icon' => 'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z'],
    ] as $stat)
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
            <div class="w-8 h-8 rounded-lg
                        bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/40
                        flex items-center justify-center">
                <svg class="w-4 h-4 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Recent Applications --}}
    <div class="card">
        <div class="flex items-center justify-between px-5 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-white">Recent Applications</h2>
            <a href="{{ route('seeker.applications.index') }}"
               class="text-xs text-brand-600 dark:text-brand-400 hover:underline">
                View all
            </a>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentApplications as $app)
            <div class="px-5 py-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="{{ $app->job->company->logoUrl() }}"
                             alt="{{ $app->job->company->name }}"
                             class="w-9 h-9 rounded-lg object-cover
                                    border border-gray-200 dark:border-gray-700 flex-shrink-0">
                        <div class="min-w-0">
                            <a href="{{ route('jobs.show', $app->job->slug) }}"
                               class="text-sm font-medium text-gray-900 dark:text-white
                                      hover:text-brand-600 dark:hover:text-brand-400
                                      transition-colors truncate block">
                                {{ $app->job->title }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ $app->job->company->name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1 flex-shrink-0">
                        <span class="{{ $app->statusBadgeClass() }}">
                            {{ $app->statusLabel() }}
                        </span>
                        <span class="text-xs text-gray-400">
                            {{ $app->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-5 py-10 text-center">
                <div class="text-4xl mb-3">📝</div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                    No applications yet.
                </p>
                <a href="{{ route('jobs.index') }}" class="btn-primary text-sm">
                    Browse Jobs
                </a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Saved Jobs --}}
    <div class="card">
        <div class="flex items-center justify-between px-5 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-white">Saved Jobs</h2>
            <a href="{{ route('seeker.saved.index') }}"
               class="text-xs text-brand-600 dark:text-brand-400 hover:underline">
                View all
            </a>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($savedJobs as $saved)
            @if($saved->job)
            <div class="px-5 py-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <img src="{{ $saved->job->company->logoUrl() }}"
                             alt="{{ $saved->job->company->name }}"
                             class="w-9 h-9 rounded-lg object-cover
                                    border border-gray-200 dark:border-gray-700 flex-shrink-0">
                        <div class="min-w-0">
                            <a href="{{ route('jobs.show', $saved->job->slug) }}"
                               class="text-sm font-medium text-gray-900 dark:text-white
                                      hover:text-brand-600 dark:hover:text-brand-400
                                      transition-colors truncate block">
                                {{ $saved->job->title }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $saved->job->company->name }} ·
                                {{ $saved->job->locationLabel() }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('jobs.show', $saved->job->slug) }}"
                       class="btn-primary text-xs py-1 px-2.5 whitespace-nowrap">
                        Apply
                    </a>
                </div>
            </div>
            @endif
            @empty
            <div class="px-5 py-10 text-center">
                <div class="text-4xl mb-3">🔖</div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                    No saved jobs yet.
                </p>
                <a href="{{ route('jobs.index') }}" class="btn-secondary text-sm">
                    Browse Jobs
                </a>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
