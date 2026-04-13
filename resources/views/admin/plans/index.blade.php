@extends('layouts.admin')
@section('title', 'Plans')
@section('page-title', 'Subscription Plans')
@section('page-subtitle', 'Manage pricing and plan features')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.plans.create') }}" class="btn-primary">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Create Plan
    </a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    @foreach($plans as $plan)
    <div class="card p-6 relative">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ $plan->name }}</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->slug }}</p>
            </div>
            <span class="{{ $plan->is_active ? 'badge-green' : 'badge-gray' }}">
                {{ $plan->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>

        <div class="mb-4">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                NPR {{ number_format($plan->price_monthly) }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">/month</p>
            @if($plan->price_yearly > 0)
                <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">
                    NPR {{ number_format($plan->price_yearly) }}/year
                    ({{ $plan->yearlyDiscount() }}% off)
                </p>
            @endif
        </div>

        <ul class="space-y-1.5 text-xs text-gray-600 dark:text-gray-400 mb-5">
            <li>{{ $plan->max_jobs ? $plan->max_jobs . ' max jobs' : 'Unlimited jobs' }}</li>
            <li>{{ $plan->max_recruiters }} team {{ Str::plural('member', $plan->max_recruiters) }}</li>
            <li>ATS: {{ $plan->has_ats ? 'Yes' : 'No' }}</li>
            <li>Analytics: {{ $plan->has_analytics ? 'Yes' : 'No' }}</li>
            <li>Featured jobs: {{ $plan->featured_jobs_allowed ? 'Yes' : 'No' }}</li>
        </ul>

        <div class="pt-3 border-t border-gray-100 dark:border-gray-800">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                {{ $plan->companies_count }} {{ Str::plural('company', $plan->companies_count) }} on this plan
            </p>
            <div class="flex gap-2">
                <a href="{{ route('admin.plans.edit', $plan) }}"
                   class="btn-secondary text-xs flex-1 justify-center">Edit</a>
                @if($plan->companies_count === 0)
                <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}"
                      onsubmit="return confirm('Delete this plan?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs px-3 py-1.5 rounded-lg border border-red-200
                                   text-red-600 hover:bg-red-50 dark:border-red-800
                                   dark:text-red-400 transition-colors">
                        Delete
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
