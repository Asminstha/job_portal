@extends('layouts.app')
@section('title', 'Subscription')
@section('page-title', 'Subscription & Billing')
@section('page-subtitle', 'Manage your plan and upgrade')

@section('content')

{{-- Current Status --}}
<div class="card p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-semibold text-gray-900 dark:text-white text-lg">
                Current Plan:
                <span class="text-brand-600 dark:text-brand-400">{{ $currentPlan->name }}</span>
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
            <p class="text-xs text-gray-500 dark:text-gray-400">per month</p>
        </div>
    </div>
</div>

{{-- Pending request banner --}}
@if($pendingRequest)
<div class="mb-6 p-4 bg-amber-50 dark:bg-amber-900/30
            border border-amber-200 dark:border-amber-700 rounded-xl">
    <div class="flex items-center gap-3">
        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                Payment Verification Pending
            </p>
            <p class="text-xs text-amber-700 dark:text-amber-300 mt-0.5">
                Your upgrade request for the
                <strong>{{ $pendingRequest->plan->name }} Plan</strong>
                is being reviewed. We will activate it within 24 hours.
            </p>
        </div>
    </div>
</div>
@endif

{{-- Plans --}}
<h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Available Plans</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8" x-data="{ selectedPlan: null }">
    @foreach($plans as $plan)
    <div class="card p-6 relative cursor-pointer transition-all
                {{ $plan->id === $currentPlan->id ? 'ring-2 ring-brand-500' : '' }}
                {{ $plan->slug === 'professional' ? 'border-brand-300 dark:border-brand-700' : '' }}"
         @click="selectedPlan = {{ $plan->id }}">

        @if($plan->slug === 'professional')
            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                <span class="badge badge-blue px-3 py-1 shadow-sm">Most Popular</span>
            </div>
        @endif

        @if($plan->id === $currentPlan->id)
            <div class="absolute -top-3 right-4">
                <span class="badge badge-green px-3 py-1 shadow-sm">Current</span>
            </div>
        @endif

        <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-1">{{ $plan->name }}</h3>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 leading-relaxed">
            {{ $plan->description }}
        </p>

        <div class="mb-5">
            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                NPR {{ number_format($plan->price_monthly) }}
            </span>
            <span class="text-gray-500 dark:text-gray-400 text-sm">/month</span>
            @if($plan->price_yearly > 0)
                <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                    NPR {{ number_format($plan->price_yearly) }}/year
                    — save {{ $plan->yearlyDiscount() }}%
                </p>
            @endif
        </div>

        <ul class="space-y-2 mb-6 text-sm text-gray-600 dark:text-gray-400">
            @foreach([
                [$plan->max_jobs ? $plan->max_jobs . ' job postings' : 'Unlimited jobs', true],
                [$plan->max_recruiters . ' team ' . Str::plural('member', $plan->max_recruiters), true],
                ['ATS pipeline', $plan->has_ats],
                ['Analytics & reports', $plan->has_analytics],
                ['Featured job posts', $plan->featured_jobs_allowed],
            ] as [$text, $enabled])
            <li class="flex items-center gap-2">
                @if($enabled)
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $text }}</span>
                @else
                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-400 dark:text-gray-600">{{ $text }}</span>
                @endif
            </li>
            @endforeach
        </ul>

        @if($plan->id === $currentPlan->id)
            <button disabled
                    class="w-full justify-center btn-secondary opacity-60 cursor-not-allowed text-sm">
                Current Plan
            </button>
        @elseif($plan->price_monthly === 0)
            <button disabled
                    class="w-full justify-center btn-secondary opacity-60 cursor-not-allowed text-sm">
                Free Plan
            </button>
        @else
            <button @click.stop="selectedPlan = {{ $plan->id }}; $nextTick(() => document.getElementById('upgrade-form').scrollIntoView({behavior:'smooth'}))"
                    class="btn-primary w-full justify-center text-sm
                           {{ $pendingRequest ? 'opacity-60 cursor-not-allowed' : '' }}"
                    {{ $pendingRequest ? 'disabled' : '' }}>
                Upgrade to {{ $plan->name }}
            </button>
        @endif
    </div>
    @endforeach
</div>

{{-- Upgrade Request Form --}}
@if(!$pendingRequest)
<div id="upgrade-form" class="card p-6 mb-6" x-data="{ plan: null, cycle: 'monthly' }">
    <h2 class="font-semibold text-gray-900 dark:text-white text-lg mb-2">
        Request Plan Upgrade
    </h2>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Select your plan, make the payment, upload proof, and we'll activate within 24 hours.
    </p>

    <form method="POST" action="{{ route('company.subscription.upgrade') }}"
          enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Select Plan <span class="text-red-500">*</span></label>
                <select name="plan_id" class="form-input" x-model="plan" required>
                    <option value="">Choose a plan</option>
                    @foreach($plans->where('price_monthly', '>', 0) as $plan)
                        <option value="{{ $plan->id }}">
                            {{ $plan->name }} — NPR {{ number_format($plan->price_monthly) }}/mo
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Billing Cycle <span class="text-red-500">*</span></label>
                <select name="billing_cycle" class="form-input" x-model="cycle" required>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly (save 2 months)</option>
                </select>
            </div>
        </div>

        {{-- Payment info box --}}
        <div class="p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-xl">
            <p class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-2">
                Payment Details
            </p>
            <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                <p>eSewa: <strong>9800000000</strong> (JobsNepal Pvt. Ltd.)</p>
                <p>Khalti: <strong>9800000000</strong></p>
                <p>Bank Transfer: <strong>NIC Asia Bank — 1234567890</strong> (JobsNepal Pvt. Ltd.)</p>
            </div>
            <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">
                After payment, upload a screenshot or receipt below.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Payment Method <span class="text-red-500">*</span></label>
                <select name="payment_method" class="form-input" required>
                    <option value="">Select method</option>
                    <option value="eSewa">eSewa</option>
                    <option value="Khalti">Khalti</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Mobile Banking">Mobile Banking</option>
                </select>
            </div>
            <div>
                <label class="form-label">Transaction Reference</label>
                <input type="text" name="payment_ref" class="form-input"
                       placeholder="e.g. TXN123456789">
            </div>
        </div>

        <div>
            <label class="form-label">Payment Proof (Screenshot/Receipt) <span class="text-red-500">*</span></label>
            <input type="file" name="payment_proof"
                   accept="image/jpeg,image/png,image/jpg,application/pdf"
                   required
                   class="block w-full text-sm text-gray-500 dark:text-gray-400
                          file:mr-3 file:py-2 file:px-4 file:rounded-lg
                          file:border-0 file:text-sm file:font-medium
                          file:bg-brand-50 file:text-brand-700
                          dark:file:bg-brand-900 dark:file:text-brand-300
                          hover:file:bg-brand-100 transition-colors cursor-pointer">
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                JPG, PNG, or PDF — max 5MB
            </p>
            @error('payment_proof')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary px-8 py-3">
            Submit Upgrade Request
        </button>
    </form>
</div>
@endif

{{-- Payment methods info --}}
<div class="card p-6">
    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Need Help?</h3>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Having trouble upgrading? Contact us at
        <a href="mailto:billing@jobsnepal.com"
           class="text-brand-600 dark:text-brand-400 hover:underline">
            billing@jobsnepal.com
        </a>
        or call <strong>+977 01-XXXXXXX</strong>.
        We activate plans within 24 hours on business days.
    </p>
</div>

@endsection
