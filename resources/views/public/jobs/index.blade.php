@extends('layouts.public')
@section('title', 'Browse Jobs in Nepal')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Browse Jobs
            @if(request()->anyFilled(['q','category','location','type','location_type']))
                <span class="text-base font-normal text-gray-400 ml-2">— filtered results</span>
            @endif
        </h1>
        @if($jobs->total() > 0)
            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                Showing {{ $jobs->firstItem() }}–{{ $jobs->lastItem() }}
                of {{ number_format($jobs->total()) }} jobs
            </p>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Filter Sidebar --}}
        <aside class="w-full lg:w-64 flex-shrink-0">
            <form method="GET" action="{{ route('jobs.index') }}">
                <div class="card p-5 space-y-4 sticky top-24">

                    <h2 class="font-semibold text-gray-900 dark:text-white text-sm">Filter Jobs</h2>

                    <div>
                        <label class="form-label">Keyword</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                               class="form-input" placeholder="Title, skill, company">
                    </div>

                    <div>
                        <label class="form-label">Location</label>
                        <input type="text" name="location" value="{{ request('location') }}"
                               class="form-input" placeholder="Kathmandu, Pokhara...">
                    </div>

                    <div>
                        <label class="form-label">Category</label>
                        <select name="category" class="form-input">
                            <option value="">All categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}"
                                    {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Job Type</label>
                        <select name="type" class="form-input">
                            <option value="">All types</option>
                            <option value="full_time"  {{ request('type') === 'full_time'  ? 'selected' : '' }}>Full Time</option>
                            <option value="part_time"  {{ request('type') === 'part_time'  ? 'selected' : '' }}>Part Time</option>
                            <option value="contract"   {{ request('type') === 'contract'   ? 'selected' : '' }}>Contract</option>
                            <option value="internship" {{ request('type') === 'internship' ? 'selected' : '' }}>Internship</option>
                            <option value="freelance"  {{ request('type') === 'freelance'  ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Work Mode</label>
                        <select name="location_type" class="form-input">
                            <option value="">Any mode</option>
                            <option value="remote" {{ request('location_type') === 'remote' ? 'selected' : '' }}>Remote</option>
                            <option value="onsite" {{ request('location_type') === 'onsite' ? 'selected' : '' }}>On-site</option>
                            <option value="hybrid" {{ request('location_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Experience</label>
                        <select name="experience" class="form-input">
                            <option value="">Any level</option>
                            <option value="0" {{ request('experience') === '0' ? 'selected' : '' }}>Fresher (0 years)</option>
                            <option value="1" {{ request('experience') === '1' ? 'selected' : '' }}>1+ years</option>
                            <option value="3" {{ request('experience') === '3' ? 'selected' : '' }}>3+ years</option>
                            <option value="5" {{ request('experience') === '5' ? 'selected' : '' }}>5+ years</option>
                        </select>
                    </div>

                    <div>
                        <label class="form-label">Sort By</label>
                        <select name="sort" class="form-input">
                            <option value="latest"      {{ request('sort','latest') === 'latest'      ? 'selected' : '' }}>Latest First</option>
                            <option value="salary_high" {{ request('sort') === 'salary_high' ? 'selected' : '' }}>Highest Salary</option>
                            <option value="salary_low"  {{ request('sort') === 'salary_low'  ? 'selected' : '' }}>Lowest Salary</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary w-full justify-center">
                        Apply Filters
                    </button>

                    @if(request()->anyFilled(['q','category','location','type','location_type','experience','sort']))
                        <a href="{{ route('jobs.index') }}"
                           class="block text-center text-sm text-red-500 hover:text-red-700
                                  dark:text-red-400 dark:hover:text-red-300 transition-colors">
                            ✕ Clear all filters
                        </a>
                    @endif
                </div>
            </form>
        </aside>

        {{-- Results --}}
        <div class="flex-1 min-w-0">
            @if($jobs->isNotEmpty())
                <div class="space-y-3">
                    @foreach($jobs as $job)
                        @include('components.job-card', ['job' => $job])
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="card p-12 text-center">
                    <div class="text-5xl mb-4">🔍</div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        No jobs found
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">
                        Try adjusting your filters or search with different keywords.
                    </p>
                    <a href="{{ route('jobs.index') }}" class="btn-secondary">Clear Filters</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
