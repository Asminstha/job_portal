@extends('layouts.admin')
@section('title', $company->name)
@section('page-title', $company->name)
@section('page-subtitle', 'Company detail view')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: Company info --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Header --}}
        <div class="card p-6">
            <div class="flex items-start gap-5">
                <img src="{{ $company->logoUrl() }}" alt="{{ $company->name }}"
                     class="w-16 h-16 rounded-xl object-cover border border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $company->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $company->email }}</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="{{ $company->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $company->is_active ? 'Active' : 'Suspended' }}
                        </span>
                        <span class="{{ match($company->subscription_status) {
                            'active' => 'badge-green', 'trial' => 'badge-yellow',
                            default => 'badge-red'
                        } }}">
                            {{ ucfirst($company->subscription_status) }}
                        </span>
                        @if($company->plan)
                            <span class="badge badge-blue">{{ $company->plan->name }} Plan</span>
                        @endif
                    </div>
                </div>
            </div>

            <dl class="grid grid-cols-2 gap-4 mt-5 text-sm">
                @foreach([
                    ['label' => 'Industry',  'value' => $company->industry  ?? '—'],
                    ['label' => 'Size',      'value' => $company->size      ?? '—'],
                    ['label' => 'City',      'value' => $company->city      ?? '—'],
                    ['label' => 'Phone',     'value' => $company->phone     ?? '—'],
                    ['label' => 'Website',   'value' => $company->website   ?? '—'],
                    ['label' => 'Joined',    'value' => $company->created_at->format('M d, Y')],
                    ['label' => 'Trial ends','value' => $company->trial_ends_at?->format('M d, Y') ?? '—'],
                ] as $item)
                <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">{{ $item['label'] }}</dt>
                    <dd class="font-medium text-gray-900 dark:text-white mt-0.5">{{ $item['value'] }}</dd>
                </div>
                @endforeach
            </dl>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4">
            @foreach([
                ['label' => 'Total Jobs',    'value' => $stats['total_jobs'],   'color' => 'blue'],
                ['label' => 'Active Jobs',   'value' => $stats['active_jobs'],  'color' => 'green'],
                ['label' => 'Applications',  'value' => $stats['applications'], 'color' => 'purple'],
            ] as $stat)
            <div class="card p-4 text-center">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 mt-1">
                    {{ $stat['label'] }}
                </p>
            </div>
            @endforeach
        </div>

        {{-- Recent jobs --}}
        <div class="card">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-900 dark:text-white">Recent Jobs</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($recentJobs as $job)
                <div class="px-5 py-3 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $job->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $job->typeLabel() }} · {{ $job->locationLabel() }}
                        </p>
                    </div>
                    @php
                        $jClass = match($job->status) {
                            'active'  => 'badge-green',
                            'draft'   => 'badge-gray',
                            'paused'  => 'badge-yellow',
                            default   => 'badge-red',
                        };
                    @endphp
                    <span class="{{ $jClass }}">{{ ucfirst($job->status) }}</span>
                </div>
                @empty
                <div class="px-5 py-6 text-center text-sm text-gray-400">No jobs posted yet.</div>
                @endforelse
            </div>
        </div>

        {{-- Team members --}}
        <div class="card">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-900 dark:text-white">Team Members</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($company->users as $member)
                <div class="px-5 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900
                                flex items-center justify-center text-brand-700 text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $member->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $member->email }}</p>
                    </div>
                    <span class="badge badge-gray">{{ ucfirst(str_replace('_',' ', $member->role)) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right: Actions --}}
    <div class="space-y-5">

        {{-- Actions --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
            <div class="space-y-3">
                <form method="POST" action="{{ route('admin.companies.toggle', $company) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="w-full justify-center {{ $company->is_active ? 'btn-danger' : 'btn-primary' }}">
                        {{ $company->is_active ? 'Suspend Company' : 'Activate Company' }}
                    </button>
                </form>

                <a href="{{ route('companies.show', $company->slug) }}" target="_blank"
                   class="btn-secondary w-full justify-center text-sm">
                    View Public Profile
                </a>
            </div>
        </div>

        {{-- Change plan --}}
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Change Plan</h3>
            <form method="POST" action="{{ route('admin.companies.plan', $company) }}"
                  class="space-y-3">
                @csrf @method('PATCH')
                <select name="plan_id" class="form-input w-full">
                    @foreach(\App\Models\Plan::orderBy('sort_order')->get() as $plan)
                        <option value="{{ $plan->id }}"
                            {{ $company->plan_id === $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} — NPR {{ number_format($plan->price_monthly) }}/mo
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary w-full justify-center">
                    Update Plan
                </button>
            </form>
        </div>

        {{-- Subscription history --}}
        @if($company->subscriptions->isNotEmpty())
        <div class="card p-5">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Subscription History</h3>
            <div class="space-y-3">
                @foreach($company->subscriptions->sortByDesc('created_at')->take(5) as $sub)
                <div class="flex items-center justify-between text-sm">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $sub->plan->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $sub->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900 dark:text-white">
                            NPR {{ number_format($sub->amount_paid) }}
                        </p>
                        <span class="{{ $sub->status === 'active' ? 'badge-green' : 'badge-gray' }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <a href="{{ route('admin.companies.index') }}" class="btn-secondary w-full justify-center">
            ← Back to Companies
        </a>
    </div>

</div>

@endsection
