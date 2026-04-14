@extends('emails.layout')

@section('content')
<h2>Your Application Has Been Updated</h2>
<p>Hi <strong>{{ $application->user->name }}</strong>,</p>
<p>
    There is an update on your application for
    <strong>{{ $application->job->title }}</strong>
    at <strong>{{ $application->job->company->name }}</strong>.
</p>

<div class="info-box">
    <div class="info-row">
        <span class="info-label">Position</span>
        <span class="info-value">{{ $application->job->title }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Company</span>
        <span class="info-value">{{ $application->job->company->name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">New Status</span>
        <span class="info-value">
            @php
                $badgeClass = match($application->status) {
                    'shortlisted' => 'badge-purple',
                    'interview'   => 'badge-blue',
                    'offered'     => 'badge-green',
                    'hired'       => 'badge-green',
                    'rejected'    => 'badge-red',
                    default       => 'badge-yellow',
                };
            @endphp
            <span class="badge {{ $badgeClass }}">
                {{ $application->statusLabel() }}
            </span>
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Updated</span>
        <span class="info-value">{{ now()->format('M d, Y \a\t h:i A') }}</span>
    </div>
</div>

@if($application->status === 'interview')
<div class="info-box" style="border-color: #bfdbfe; background: #eff6ff;">
    <p style="color: #1e40af; font-weight: 600; margin-bottom: 8px;">
        Congratulations! You have been shortlisted for an interview.
    </p>
    <p style="color: #1e40af; font-size: 14px; margin: 0;">
        The company will contact you soon with interview details.
        Please check your email regularly.
    </p>
</div>
@endif

@if($application->status === 'offered')
<div class="info-box" style="border-color: #bbf7d0; background: #f0fdf4;">
    <p style="color: #166534; font-weight: 600; margin-bottom: 8px;">
        Congratulations! You have received a job offer!
    </p>
    <p style="color: #166534; font-size: 14px; margin: 0;">
        Please log in to your dashboard to view the details and respond.
    </p>
</div>
@endif

@if($application->status === 'rejected' && $application->rejection_reason)
<p><strong>Feedback:</strong></p>
<div class="info-box">
    <p style="font-size: 14px;">{{ $application->rejection_reason }}</p>
</div>
@endif

<div style="text-align: center; margin-top: 24px;">
    <a href="{{ config('app.url') }}/my/applications" class="btn">
        Track My Applications
    </a>
</div>

<p style="font-size: 13px; color: #6b7280; margin-top: 20px;">
    Don't be discouraged — keep applying! There are many opportunities waiting for you on JobsNepal.
</p>
@endsection
