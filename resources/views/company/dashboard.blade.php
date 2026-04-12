@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('content')

{{-- Trial banner --}}
@if($company->isOnTrial())
<div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/30 border border-amber-200
            dark:border-amber-700 rounded-xl flex items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm text-amber-800 dark:text-amber-200">
            <strong>Free trial:</strong> {{ $company->trialDaysLeft() }} days remaining.
            Upgrade to keep posting jobs after your trial ends.
        </p>
    </div>
    <a href="{{ route('company.subscription.index') }}"
       class="btn-primary text-xs whitespace-nowrap">Upgrade Now</a>
</div>
@endif

{{-- Stats grid --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

    @foreach([
        ['label' => 'Total Jobs',        'value' => $stats['total_jobs'],         'color' => 'blue',   'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        ['label' => 'Active Jobs',        'value' => $stats['active_jobs'],        'color' => 'green',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Total Applications', 'value' => $stats['total_applications'], 'color' => 'purple', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['label' => 'New / Unread',       'value' => $stats['new_applications'],   'color' => 'yellow', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
        ['label' => 'Shortlisted',        'value' => $stats['shortlisted'],        'color' => 'teal',   'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
        ['label' => 'Hired',              'value' => $stats['hired'],              'color' => 'green',  'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
    ] as $stat)
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
            <div class="w-8 h-8 rounded-lg bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/40
                        flex items-center justify-center">
                <svg class="w-4 h-4 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
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
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-white">Recent Applications</h2>
            <a href="{{ route('company.applications.index', 'all') }}"
               class="text-xs text-brand-600 dark:text-brand-400 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentApplications as $app)
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900
                            flex items-center justify-center text-brand-700 dark:text-brand-300
                            text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($app->user->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ $app->user->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ $app->job->title ?? 'Unknown Job' }}
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <span class="{{ $app->statusBadgeClass() }}">
                        {{ $app->statusLabel() }}
                    </span>
                    <span class="text-xs text-gray-400">
                        {{ $app->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                No applications yet. Post a job to start receiving applications!
            </div>
            @endforelse
        </div>
    </div>

    {{-- Active Jobs --}}
    <div class="card">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-white">Active Jobs</h2>
            <a href="{{ route('company.jobs.create') }}" class="btn-primary text-xs">+ Post Job</a>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($activeJobs as $job)
            <div class="px-5 py-3 flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ $job->title }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $job->applications_count }} applicants ·
                        {{ $job->locationLabel() }}
                    </p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('company.applications.index', $job->id) }}"
                       class="btn-secondary text-xs py-1 px-2">View</a>
                    <a href="{{ route('company.jobs.edit', $job->id) }}"
                       class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">Edit</a>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center">
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-3">No active jobs yet.</p>
                <a href="{{ route('company.jobs.create') }}" class="btn-primary text-sm">Post Your First Job</a>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
