@extends('layouts.seeker')
@section('title', 'My Applications')
@section('page-title', 'My Applications')
@section('page-subtitle', 'Track all your job applications')

@section('content')

{{-- Status summary pills --}}
<div class="flex flex-wrap gap-2 mb-6">
    @php
        $allStatuses = [
            'pending'     => ['label' => 'Pending',     'class' => 'badge-yellow'],
            'reviewed'    => ['label' => 'Reviewed',    'class' => 'badge-blue'],
            'shortlisted' => ['label' => 'Shortlisted', 'class' => 'badge-purple'],
            'interview'   => ['label' => 'Interview',   'class' => 'badge-blue'],
            'offered'     => ['label' => 'Offered',     'class' => 'badge-green'],
            'hired'       => ['label' => 'Hired',       'class' => 'badge-green'],
            'rejected'    => ['label' => 'Rejected',    'class' => 'badge-red'],
            'withdrawn'   => ['label' => 'Withdrawn',   'class' => 'badge-gray'],
        ];
    @endphp

    <div class="card px-4 py-2 flex flex-wrap gap-3 w-full">
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 self-center">
            Status breakdown:
        </span>
        @foreach($allStatuses as $status => $info)
            @if(isset($statusCounts[$status]) && $statusCounts[$status] > 0)
                <span class="{{ $info['class'] }}">
                    {{ $info['label'] }}: {{ $statusCounts[$status] }}
                </span>
            @endif
        @endforeach
        @if($statusCounts->isEmpty())
            <span class="text-xs text-gray-400">No applications yet</span>
        @endif
    </div>
</div>

{{-- Applications list --}}
<div class="space-y-4">
    @forelse($applications as $app)
    <div class="card p-5 hover:shadow-md transition-shadow">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">

            {{-- Company logo + job info --}}
            <div class="flex items-start gap-4 flex-1 min-w-0">
                <img src="{{ $app->job->company->logoUrl() }}"
                     alt="{{ $app->job->company->name }}"
                     class="w-12 h-12 rounded-xl object-cover
                            border border-gray-200 dark:border-gray-700 flex-shrink-0">

                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-start gap-2">
                        <a href="{{ route('jobs.show', $app->job->slug) }}"
                           class="text-base font-semibold text-gray-900 dark:text-white
                                  hover:text-brand-600 dark:hover:text-brand-400
                                  transition-colors">
                            {{ $app->job->title }}
                        </a>
                        <span class="{{ $app->statusBadgeClass() }}">
                            {{ $app->statusLabel() }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $app->job->company->name }}
                    </p>

                    <div class="flex flex-wrap gap-3 mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827
                                         0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $app->job->locationLabel() }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0
                                         00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Applied {{ $app->created_at->format('M d, Y') }}
                        </span>
                        @if($app->status_changed_at && $app->status !== 'pending')
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Updated {{ $app->status_changed_at->diffForHumans() }}
                            </span>
                        @endif
                    </div>

                    {{-- Status message --}}
                    @if($app->status === 'rejected' && $app->rejection_reason)
                        <div class="mt-2 p-2 bg-red-50 dark:bg-red-900/20 rounded-lg
                                    text-xs text-red-700 dark:text-red-300">
                            {{ $app->rejection_reason }}
                        </div>
                    @endif

                    @if($app->status === 'interview')
                        <div class="mt-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg
                                    text-xs text-blue-700 dark:text-blue-300 font-medium">
                            🎉 You have been shortlisted for an interview! Check your email.
                        </div>
                    @endif

                    @if($app->status === 'offered')
                        <div class="mt-2 p-2 bg-green-50 dark:bg-green-900/20 rounded-lg
                                    text-xs text-green-700 dark:text-green-300 font-medium">
                            🎊 Congratulations! You have received a job offer!
                        </div>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('jobs.show', $app->job->slug) }}"
                   class="btn-secondary text-xs py-1.5 px-3">
                    View Job
                </a>

                @if(!in_array($app->status, ['withdrawn', 'hired', 'rejected']))
                    <form method="POST"
                          action="{{ route('seeker.applications.withdraw', $app->id) }}"
                          onsubmit="return confirm('Withdraw this application?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-xs px-3 py-1.5 rounded-lg border
                                       border-red-200 dark:border-red-800
                                       text-red-600 dark:text-red-400
                                       hover:bg-red-50 dark:hover:bg-red-900/20
                                       transition-colors">
                            Withdraw
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
    @empty
    <div class="card p-16 text-center">
        <div class="text-6xl mb-4">📋</div>
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
            No applications yet
        </h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-5">
            Start applying to jobs to track them here.
        </p>
        <a href="{{ route('jobs.index') }}" class="btn-primary">Browse Jobs</a>
    </div>
    @endforelse
</div>

@if($applications->hasPages())
    <div class="mt-6">{{ $applications->links() }}</div>
@endif

@endsection
