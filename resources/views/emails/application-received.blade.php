@extends('emails.layout')

@section('content')
<h2>New Application Received!</h2>
<p>
    A candidate has applied for <strong>{{ $application->job->title }}</strong>.
    Here are the details:
</p>

<div class="info-box">
    <div class="info-row">
        <span class="info-label">Candidate</span>
        <span class="info-value">{{ $application->user->name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-value">{{ $application->user->email }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Position</span>
        <span class="info-value">{{ $application->job->title }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Applied On</span>
        <span class="info-value">{{ $application->created_at->format('M d, Y \a\t h:i A') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Status</span>
        <span class="info-value">
            <span class="badge badge-yellow">Pending Review</span>
        </span>
    </div>
</div>

@if($application->cover_letter)
<p><strong>Cover Letter:</strong></p>
<div class="info-box">
    <p style="font-size:14px; white-space: pre-line;">{{ Str::limit($application->cover_letter, 300) }}</p>
</div>
@endif

<div style="text-align:center; margin-top: 24px;">
    <a href="{{ config('app.url') }}/dashboard/applications/{{ $application->job_id }}/{{ $application->id }}"
       class="btn">
        View Full Application
    </a>
</div>
@endsection
