@extends('layouts.seeker')
@section('title', 'Saved Jobs')
@section('page-title', 'Saved Jobs')
@section('page-subtitle', 'Jobs you have bookmarked')

@section('content')

@if($savedJobs->isNotEmpty())
    <div class="grid gap-4">
        @foreach($savedJobs as $saved)
            @if($saved->job)
            <div class="card p-5 hover:shadow-md transition-shadow group">
                <div class="flex items-start gap-4">

                    <a href="{{ route('companies.show', $saved->job->company->slug) }}"
                       class="flex-shrink-0">
                        <img src="{{ $saved->job->company->logoUrl() }}"
                             alt="{{ $saved->job->company->name }}"
                             class="w-12 h-12 rounded-xl object-cover
                                    border border-gray-200 dark:border-gray-700">
                    </a>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <a href="{{ route('jobs.show', $saved->job->slug) }}"
                                   class="text-base font-semibold text-gray-900 dark:text-white
                                          group-hover:text-brand-600 dark:group-hover:text-brand-400
                                          transition-colors block">
                                    {{ $saved->job->title }}
                                </a>
                                <a href="{{ route('companies.show', $saved->job->company->slug) }}"
                                   class="text-sm text-gray-500 dark:text-gray-400
                                          hover:text-brand-600 transition-colors">
                                    {{ $saved->job->company->name }}
                                </a>
                            </div>
                            @if($saved->job->is_featured)
                                <span class="badge badge-yellow flex-shrink-0">Featured</span>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center gap-3 mt-2
                                    text-xs text-gray-500 dark:text-gray-400">
                            <span>📍 {{ $saved->job->locationLabel() }}</span>
                            <span>⏰ {{ $saved->job->typeLabel() }}</span>
                            <span>💰 {{ $saved->job->salaryDisplay() }}</span>
                            @if($saved->job->category)
                                <span class="badge badge-blue">
                                    {{ $saved->job->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="hidden sm:flex flex-col items-end gap-2 flex-shrink-0">
                        <span class="text-xs text-gray-400">
                            Saved {{ \Carbon\Carbon::parse($saved->created_at)->diffForHumans() }}
                        </span>
                        <div class="flex gap-2">
                            <a href="{{ route('jobs.show', $saved->job->slug) }}"
                               class="btn-primary text-xs py-1.5 px-3">
                                Apply Now
                            </a>
                            <form method="POST"
                                  action="{{ route('seeker.saved.toggle', $saved->job->id) }}">
                                @csrf
                                <button type="submit"
                                        class="text-xs px-3 py-1.5 rounded-lg border
                                               border-gray-300 dark:border-gray-600
                                               text-gray-500 dark:text-gray-400
                                               hover:border-red-300 hover:text-red-500
                                               dark:hover:border-red-700 dark:hover:text-red-400
                                               transition-colors"
                                        title="Remove from saved">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            @endif
        @endforeach
    </div>

    @if($savedJobs->hasPages())
        <div class="mt-6">{{ $savedJobs->links() }}</div>
    @endif

@else
    <div class="card p-16 text-center">
        <div class="text-6xl mb-4">🔖</div>
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
            No saved jobs yet
        </h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-5">
            Click the save button on any job listing to bookmark it for later.
        </p>
        <a href="{{ route('jobs.index') }}" class="btn-primary">Browse Jobs</a>
    </div>
@endif

@endsection
