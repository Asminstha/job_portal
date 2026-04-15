@extends('layouts.public')

@section('seo')
    <x-seo
        title="About Us — JobsNepal"
        description="JobsNepal is Nepal's modern job portal built to connect talented professionals with great companies. Learn about our mission and story."
    />
@endsection

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-brand-700 to-brand-900 text-white py-16 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-4xl font-bold mb-4">Built for Nepal. Built for Growth.</h1>
        <p class="text-brand-100 text-lg leading-relaxed">
            JobsNepal connects talented professionals with the companies and
            opportunities that are shaping Nepal's future.
        </p>
    </div>
</section>

{{-- Mission --}}
<section class="py-16 px-4 bg-white dark:bg-gray-900">
    <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
                <p class="text-gray-600 text-justify dark:text-gray-400 leading-relaxed mb-4">
                    Nepal has incredible talent — engineers, designers, marketers, and entrepreneurs
                    who deserve better tools to find great work. At the same time, growing companies
                    struggle to find and manage candidates efficiently.
                </p>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    JobsNepal bridges that gap with a modern, affordable hiring platform built
                    specifically for the Nepali market — with pricing in NPR, support in Nepali
                    time zones, and features that match how Nepali companies actually hire.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['num' => '500+', 'label' => 'Active Jobs'],
                    ['num' => '100+', 'label' => 'Companies'],
                    ['num' => '5,000+', 'label' => 'Job Seekers'],
                    ['num' => 'Free', 'label' => 'For Seekers'],
                ] as $stat)
                <div class="card p-5 text-center">
                    <p class="text-3xl font-bold text-brand-600 dark:text-brand-400">
                        {{ $stat['num'] }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-16 px-4 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">What We Stand For</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach([
                [
                    'icon' => '🎯',
                    'title' => 'Simplicity first',
                    'desc' => 'No bloated enterprise software. Clean, fast tools that just work for small and growing teams.',
                ],
                [
                    'icon' => '🤝',
                    'title' => 'Fair pricing',
                    'desc' => 'Priced in NPR, built for Nepali budgets. No hidden fees, no surprise charges.',
                ],
                [
                    'icon' => '🔒',
                    'title' => 'Data privacy',
                    'desc' => 'Your company data and candidate information is yours. We never sell it or share it.',
                ],
            ] as $value)
            <div class="card p-6 text-center">
                <div class="text-4xl mb-4">{{ $value['icon'] }}</div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $value['title'] }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    {{ $value['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- For employers + seekers --}}
<section class="py-16 px-4 bg-white dark:bg-gray-900">
    <div class="max-w-5xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="card p-8">
                <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900 rounded-xl
                            flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9
                                 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0
                                 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">For Employers</h3>
                <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    @foreach([
                        'Post jobs in minutes, not hours',
                        'Built-in ATS to track every candidate',
                        'Invite your team with role-based access',
                        'Start free — 14-day trial, no card needed',
                        'Payments via eSewa, Khalti, bank transfer',
                    ] as $point)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('register.company') }}" class="btn-primary mt-6 inline-flex">
                    Start Hiring Free
                </a>
            </div>

            <div class="card p-8">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-xl
                            flex items-center justify-center mb-5">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">For Job Seekers</h3>
                <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    @foreach([
                        'Always 100% free — no hidden costs',
                        'Build a professional profile with your CV',
                        'Apply to jobs in one click',
                        'Track every application in real time',
                        'Get notified when status changes',
                    ] as $point)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('register.seeker') }}" class="btn-secondary mt-6 inline-flex">
                    Create Free Account
                </a>
            </div>

        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-14 px-4 bg-brand-600 dark:bg-brand-800">
    <div class="max-w-3xl mx-auto text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-brand-100 mb-8">
            Join hundreds of companies and thousands of job seekers already on JobsNepal.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('register.company') }}"
               class="px-8 py-3.5 bg-white text-brand-700 font-semibold rounded-xl
                      hover:bg-brand-50 transition-colors">
                Post Jobs Free
            </a>
            <a href="{{ route('contact') }}"
               class="px-8 py-3.5 border-2 border-white/60 text-white font-semibold
                      rounded-xl hover:bg-white/10 transition-colors">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection
