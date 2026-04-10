@extends('layouts.public')

@section('title', 'Find Your Dream Job in Nepal')

@section('content')

{{-- Hero Section --}}
<section class="bg-gradient-to-br from-brand-600 to-brand-800 dark:from-brand-800 dark:to-gray-900 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
            Find Your Dream Job<br>
            <span class="text-brand-200">in Nepal</span>
        </h1>
        <p class="text-lg text-brand-100 mb-10 max-w-xl mx-auto">
            Connect with top companies, startups, and agencies.
            Thousands of opportunities updated daily.
        </p>

        {{-- Search Bar --}}
        <form action="{{ route('jobs.index') }}" method="GET"
              class="flex flex-col sm:flex-row gap-3 max-w-2xl mx-auto">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" placeholder="Job title, keyword, or company"
                       value="{{ request('q') }}"
                       class="w-full pl-10 pr-4 py-3.5 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-white">
            </div>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input type="text" name="location" placeholder="City or remote"
                       value="{{ request('location') }}"
                       class="w-full pl-10 pr-4 py-3.5 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-white">
            </div>
            <button type="submit" class="px-8 py-3.5 bg-white text-brand-700 font-semibold rounded-xl hover:bg-brand-50 transition-colors whitespace-nowrap">
                Search Jobs
            </button>
        </form>

        {{-- Quick stats --}}
        <div class="flex justify-center gap-8 mt-10 text-sm text-brand-200">
            <span><strong class="text-white text-lg">500+</strong><br>Active Jobs</span>
            <span><strong class="text-white text-lg">120+</strong><br>Companies</span>
            <span><strong class="text-white text-lg">5,000+</strong><br>Job Seekers</span>
        </div>
    </div>
</section>

{{-- Popular Categories --}}
<section class="py-14 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Browse by Category</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Find jobs in your field of expertise</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $cat)
            <a href="{{ route('jobs.index', ['category' => $cat->slug]) }}"
               class="card p-4 text-center hover:border-brand-300 dark:hover:border-brand-700 hover:shadow-md transition-all group">
                <div class="text-2xl mb-2">{{ $cat->icon }}</div>
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-brand-600 dark:group-hover:text-brand-400">
                    {{ $cat->name }}
                </div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $cat->jobs_count }} jobs</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Jobs --}}
<section class="py-14 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Latest Jobs</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Fresh opportunities added today</p>
            </div>
            <a href="{{ route('jobs.index') }}" class="btn-secondary">View all jobs</a>
        </div>
        <div class="grid gap-4">
            @forelse($latestJobs as $job)
                @include('components.job-card', ['job' => $job])
            @empty
                <p class="text-gray-400 text-center py-12">No jobs posted yet. Be the first to post!</p>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA for employers --}}
<section class="py-16 bg-brand-600 dark:bg-brand-800">
    <div class="max-w-4xl mx-auto px-4 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Hire Great Talent?</h2>
        <p class="text-brand-100 mb-8 max-w-xl mx-auto">
            Post your first job for free. Start your 14-day trial today.
            No credit card required.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('register.company') }}"
               class="px-8 py-3.5 bg-white text-brand-700 font-semibold rounded-xl hover:bg-brand-50 transition-colors">
                Post a Job — Free Trial
            </a>
            <a href="{{ route('pricing') }}"
               class="px-8 py-3.5 border-2 border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-colors">
                See Pricing
            </a>
        </div>
    </div>
</section>

@endsection
