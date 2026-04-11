@extends('layouts.public')
@section('title', 'Find Your Dream Job in Nepal')

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-brand-600 to-brand-800 dark:from-brand-800 dark:to-gray-900 text-white py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">

        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm
                    border border-white/20 rounded-full px-4 py-1.5 text-sm mb-6">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            {{ $totalJobs }}+ active jobs available right now
        </div>

        <h1 class="text-4xl md:text-6xl font-bold mb-5 leading-tight">
            Find Your Dream Job<br>
            <span class="text-brand-200">in Nepal & Beyond</span>
        </h1>
        <p class="text-lg text-brand-100 mb-10 max-w-xl mx-auto">
            Connect with top companies. Apply in seconds. Track every application.
        </p>

        {{-- Search --}}
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
  

        {{-- Quick links --}}
        <div class="flex flex-wrap justify-center gap-2 mt-6 text-sm text-brand-200">
            <span>Popular:</span>
            @foreach(['it','design','marketing','finance'] as $cat)
                <a href="{{ route('jobs.index', ['category' => $cat]) }}"
                   class="hover:text-white transition-colors underline underline-offset-2">
                    {{ ucfirst($cat) }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats Bar --}}
<div class="bg-gray-50/50 dark:bg-gray-950 py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            @php
                $stats = [
                    ['val' => number_format($totalJobs).'+', 'label' => 'Active Jobs', 'icon' => '🔥'],
                    ['val' => number_format($totalCompanies).'+', 'label' => 'Top Companies', 'icon' => '🏢'],
                    ['val' => 'Free', 'label' => 'For Job Seekers', 'icon' => '✨'],
                    ['val' => '14 Days', 'label' => 'Free Trial', 'icon' => '🚀'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="text-2xl">{{ $stat['icon'] }}</div>
                    <div>
                        <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $stat['val'] }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

{{-- Categories --}}
@if($categories->isNotEmpty())
<section class="py-14 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Browse by Category</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Find jobs in your field of expertise</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('jobs.index', ['category' => $cat->slug]) }}"
                   class="card p-5 text-center hover:border-brand-400 dark:hover:border-brand-600
                          hover:shadow-md transition-all group cursor-pointer">
                    <div class="text-3xl mb-2">{{ $cat->icon }}</div>
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300
                                group-hover:text-brand-600 dark:group-hover:text-brand-400
                                transition-colors leading-tight">
                        {{ $cat->name }}
                    </div>
                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                        {{ $cat->jobs_count }} {{ Str::plural('job', $cat->jobs_count) }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Latest Jobs --}}
<section class="py-14 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Latest Opportunities</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Fresh jobs added today</p>
            </div>
            <a href="{{ route('jobs.index') }}" class="btn-secondary text-sm">
                View all jobs
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($latestJobs->isNotEmpty())
            <div class="grid gap-3">
                @foreach($latestJobs as $job)
                    @include('components.job-card', ['job' => $job])
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('jobs.index') }}" class="btn-primary px-8">
                    Browse All Jobs
                </a>
            </div>
        @else
            <div class="card p-12 text-center">
                <div class="text-5xl mb-4">💼</div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    No jobs posted yet
                </h3>
                <p class="text-gray-400 dark:text-gray-500 mb-4 text-sm">
                    Be the first company to post a job!
                </p>
                <a href="{{ route('register.company') }}" class="btn-primary inline-flex">
                    Post First Job — Free
                </a>
            </div>
        @endif
    </div>
</section>

{{-- How it works --}}
<section class="py-14 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">How JobsNepal Works</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Get hired in 3 simple steps</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['icon' => '📝', 'title' => 'Create Your Profile', 'desc' => 'Sign up free and build your professional profile with your skills, experience, and resume.'],
                ['icon' => '🔍', 'title' => 'Browse & Apply', 'desc' => 'Search thousands of jobs. Apply in one click with your saved profile and cover letter.'],
                ['icon' => '🎉', 'title' => 'Get Hired', 'desc' => 'Track your applications in real time. Get notified when companies review your profile.'],
            ] as $step)
                <div class="text-center">
                    <div class="w-16 h-16 bg-brand-100 dark:bg-brand-900/50 rounded-2xl
                                flex items-center justify-center text-3xl mx-auto mb-4">
                        {{ $step['icon'] }}
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-brand-600 dark:bg-brand-800">
    <div class="max-w-4xl mx-auto px-4 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Find Great Talent?</h2>
        <p class="text-brand-100 mb-8 max-w-xl mx-auto">
            Start your 14-day free trial today. Post jobs, manage applications, and hire faster.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('register.company') }}"
               class="px-8 py-3.5 bg-white text-brand-700 font-semibold rounded-xl
                      hover:bg-brand-50 transition-colors">
                Start Free Trial — No Card Needed
            </a>
            <a href="{{ route('pricing') }}"
               class="px-8 py-3.5 border-2 border-white/60 text-white font-semibold
                      rounded-xl hover:bg-white/10 transition-colors">
                View Pricing
            </a>
        </div>
    </div>
</section>

@endsection
