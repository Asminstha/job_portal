@extends('emails.layout')

@section('content')
<h2>Subscription Activated!</h2>
<p>
    Your <strong>{{ $subscription->plan->name }} Plan</strong> subscription
    has been activated for <strong>{{ $subscription->company->name }}</strong>.
</p>

<div class="info-box">
    <div class="info-row">
        <span class="info-label">Plan</span>
        <span class="info-value">{{ $subscription->plan->name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Billing Cycle</span>
        <span class="info-value">{{ ucfirst($subscription->billing_cycle) }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Amount Paid</span>
        <span class="info-value">NPR {{ number_format($subscription->amount_paid) }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Valid From</span>
        <span class="info-value">{{ $subscription->current_period_start?->format('M d, Y') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Valid Until</span>
        <span class="info-value">{{ $subscription->current_period_end?->format('M d, Y') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Status</span>
        <span class="info-value">
            <span class="badge badge-green">Active</span>
        </span>
    </div>
</div>

<div class="info-box" style="background: #eff6ff; border-color: #bfdbfe;">
    <p style="color: #1e40af; font-weight: 600; margin-bottom: 8px;">What you get:</p>
    <ul style="color: #1e40af; font-size: 14px; padding-left: 16px; margin: 0;">
        <li>{{ $subscription->plan->max_jobs ? $subscription->plan->max_jobs . ' job postings' : 'Unlimited job postings' }}</li>
        <li>{{ $subscription->plan->max_recruiters }} team {{ Str::plural('member', $subscription->plan->max_recruiters) }}</li>
        @if($subscription->plan->has_ats)
            <li>Full ATS pipeline</li>
        @endif
        @if($subscription->plan->has_analytics)
            <li>Analytics & reports</li>
        @endif
    </ul>
</div>

<div style="text-align: center; margin-top: 24px;">
    <a href="{{ config('app.url') }}/dashboard" class="btn">
        Go to Dashboard
    </a>
</div>
@endsection
