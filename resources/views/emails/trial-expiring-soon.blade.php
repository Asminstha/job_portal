@extends('emails.layout')

@section('content')
<h2>Your Free Trial Expires Soon</h2>
<p>Hi <strong>{{ $company->name }}</strong>,</p>
<p>
    Your free trial on JobsNepal will expire in
    <strong>{{ $daysLeft }} {{ Str::plural('day', $daysLeft) }}</strong>.
    Upgrade now to keep posting jobs and managing applications without interruption.
</p>

<div class="info-box">
    <div class="info-row">
        <span class="info-label">Company</span>
        <span class="info-value">{{ $company->name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Trial Expires</span>
        <span class="info-value">{{ $company->trial_ends_at?->format('M d, Y') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Days Remaining</span>
        <span class="info-value">
            <span class="badge badge-yellow">{{ $daysLeft }} days</span>
        </span>
    </div>
</div>

<div class="info-box" style="border-color: #bbf7d0; background: #f0fdf4;">
    <p style="color: #166534; font-weight: 600; margin-bottom: 8px;">
        Special Offer: Save 2 months with annual billing
    </p>
    <ul style="color: #166534; font-size: 14px; padding-left: 16px; margin: 0;">
        <li>Starter Plan — NPR 1,500/month</li>
        <li>Professional Plan — NPR 3,500/month (unlimited jobs)</li>
        <li>Agency Plan — NPR 7,000/month (20 team members)</li>
    </ul>
</div>

<div style="text-align: center; margin-top: 24px;">
    <a href="{{ config('app.url') }}/dashboard/subscription" class="btn">
        Upgrade My Plan
    </a>
</div>

<p style="font-size: 13px; color: #6b7280; margin-top: 20px;">
    Questions? Reply to this email or contact us at
    <a href="mailto:support@jobsnepal.com">support@jobsnepal.com</a>
</p>
@endsection
