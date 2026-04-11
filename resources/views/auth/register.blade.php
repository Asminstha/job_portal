@extends('layouts.public')
@section('title', 'Create Account')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-xl">

        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Get started for free</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Choose how you want to use JobsNepal</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            {{-- Employer Card --}}
            <a href="{{ route('register.company') }}"
               class="card p-6 hover:border-brand-400 dark:hover:border-brand-500 hover:shadow-md transition-all group cursor-pointer block">
                <div class="w-12 h-12 bg-brand-100 dark:bg-brand-900 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand-200 dark:group-hover:bg-brand-800 transition-colors">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">I'm an Employer</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Post jobs, manage applications, and find great talent for your team.
                </p>
                <div class="mt-4 flex items-center text-sm font-medium text-brand-600 dark:text-brand-400">
                    Post jobs free
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="mt-3 text-xs text-green-600 dark:text-green-400 font-medium">
                    14-day free trial — no credit card needed
                </div>
            </a>

            {{-- Job Seeker Card --}}
            <a href="{{ route('register.seeker') }}"
               class="card p-6 hover:border-brand-400 dark:hover:border-brand-500 hover:shadow-md transition-all group cursor-pointer block">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">I'm a Job Seeker</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Create your profile, apply for jobs, and track your applications.
                </p>
                <div class="mt-4 flex items-center text-sm font-medium text-purple-600 dark:text-purple-400">
                    Find jobs free
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="mt-3 text-xs text-green-600 dark:text-green-400 font-medium">
                    Always free for job seekers
                </div>
            </a>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-brand-600 dark:text-brand-400 font-medium hover:underline">Sign in</a>
        </p>

    </div>
</div>
@endsection
