@extends('emails.layout')

@section('content')
<h2>New Company Registered</h2>
<p>A new company has joined JobsNepal and started their free trial.</p>

<div class="info-box">
    <div class="info-row">
        <span class="info-label">Company Name</span>
        <span class="info-value">{{ $company->name }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-value">{{ $company->email }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Industry</span>
        <span class="info-value">{{ $company->industry ?? 'Not specified' }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Trial Ends</span>
        <span class="info-value">{{ $company->trial_ends_at?->format('M d, Y') }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Registered</span>
        <span class="info-value">{{ $company->created_at->format('M d, Y \a\t h:i A') }}</span>
    </div>
</div>

<div style="text-align: center; margin-top: 24px;">
    <a href="{{ config('app.url') }}/admin/companies/{{ $company->id }}"
       class="btn">
        View in Admin Panel
    </a>
</div>
@endsection
