@extends('layouts.app')
@section('title', 'Subscription')
@section('page-title', 'Subscription & Billing')
@section('page-subtitle', 'Manage your plan and billing')

@section('content')

{{-- Current plan status --}}
<div class="card p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-semibold text-gray-900 dark:text-white text-lg">
                Current Plan: <span class="text-brand-600 dark:text-brand-400">{{ $currentPlan->name }}</span>
            </h2>
            @if($company->isOnTrial())
                <p class="text-sm text-amber-600 dark:text-amber-400 mt-1">
                    Free trial — {{ $company->trialDaysLeft() }} days remaining
                    (expires {{ $company->trial_ends_at->format('M d, Y') }})
                </p>
            @elseif($subscription)
                <p class="text-sm text-green-600 dark:text-green-400 mt-1">
                    Active — renews {{ $subscription->current_period_end->format('M d, Y') }}
                </p>
            @endif
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                NPR {{ number_format($currentPlan->price_monthly) }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">per month</p>
        </div>
    </div>
</div>

{{-- Plans --}}
<h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Available Plans</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @foreach($plans as $plan)
    <div class="card p-6 relative
                {{ $plan->id === $currentPlan->id ? 'ring-2 ring-brand-500' : '' }}
                {{ $plan->slug === 'professional' ? 'border-brand-300 dark:border-brand-700' : '' }}">

        @if($plan->slug === 'professional')
            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                <span class="badge badge-blue px-3 py-1">Most Popular</span>
            </div>
        @endif

        @if($plan->id === $currentPlan->id)
            <div class="absolute -top-3 right-4">
                <span class="badge badge-green px-3 py-1">Current</span>
            </div>
        @endif

        <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-1">{{ $plan->name }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $plan->description }}</p>

        <div class="mb-4">
            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                NPR {{ number_format($plan->price_monthly) }}
            </span>
            <span class="text-gray-500 dark:text-gray-400 text-sm">/month</span>
            @if($plan->price_yearly > 0)
                <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">
                    Save {{ $plan->yearlyDiscount() }}% with annual billing
                </p>
            @endif
        </div>

        <ul class="space-y-2 mb-6 text-sm text-gray-600 dark:text-gray-400">
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ $plan->max_jobs ? $plan->max_jobs . ' job postings' : 'Unlimited job postings' }}
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ $plan->max_recruiters }} team {{ Str::plural('member', $plan->max_recruiters) }}
            </li>
            <li class="flex items-center gap-2">
                @if($plan->has_ats)
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>ATS pipeline</span>
                @else
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-400">No ATS</span>
                @endif
            </li>
            <li class="flex items-center gap-2">
                @if($plan->has_analytics)
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>Analytics</span>
                @else
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-400">No analytics</span>
                @endif
            </li>
        </ul>

        @if($plan->id === $currentPlan->id)
            <button disabled class="btn-secondary w-full justify-center opacity-60 cursor-not-allowed">
                Current Plan
            </button>
        @elseif($plan->price_monthly === 0)
            <button disabled class="btn-secondary w-full justify-center opacity-60 cursor-not-allowed">
                Free Plan
            </button>
        @else
            <a href="mailto:billing@jobsnepal.com?subject=Upgrade to {{ $plan->name }} Plan&body=Company: {{ $company->name }}%0AEmail: {{ auth()->user()->email }}%0APlan: {{ $plan->name }}%0AAmount: NPR {{ $plan->price_monthly }}/month"
               class="btn-primary w-full justify-center">
                Upgrade to {{ $plan->name }}
            </a>
        @endif
    </div>
    @endforeach
</div>

{{-- Payment info --}}
<div class="card p-6">
    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Payment Methods</h3>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
        We currently accept the following payment methods in Nepal:
    </p>
    <div class="flex flex-wrap gap-3">
        @foreach(['eSewa', 'Khalti', 'Bank Transfer', 'Mobile Banking'] as $method)
            <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800
                         text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium">
                {{ $method }}
            </span>
        @endforeach
    </div>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">
        To upgrade, click the upgrade button above or contact us at
        <a href="mailto:billing@jobsnepal.com"
           class="text-brand-600 dark:text-brand-400 hover:underline">billing@jobsnepal.com</a>.
        We'll send you payment details and activate your plan within 24 hours.
    </p>
</div>

@endsection
