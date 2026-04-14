@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Platform Overview')
@section('page-subtitle', 'Real-time stats for JobsNepal')

@section('content')

{{-- Stats grid --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['label' => 'Total Companies',   'value' => $stats['total_companies'],    'sub' => $stats['active_companies'].' active',    'color' => 'blue'],
        ['label' => 'Total Jobs',        'value' => $stats['total_jobs'],         'sub' => $stats['active_jobs'].' active',         'color' => 'green'],
        ['label' => 'Job Seekers',       'value' => $stats['total_users'],        'sub' => 'registered seekers',                   'color' => 'purple'],
        ['label' => 'Applications',      'value' => $stats['total_applications'], 'sub' => 'total submitted',                      'color' => 'amber'],
        ['label' => 'Trial Companies',   'value' => $stats['trial_companies'],    'sub' => 'on free trial',                        'color' => 'yellow'],
        ['label' => 'Paid Companies',    'value' => $stats['paid_companies'],     'sub' => 'active subscriptions',                 'color' => 'green'],
        ['label' => 'Revenue (Month)',   'value' => 'NPR '.number_format($revenueThisMonth), 'sub' => 'this month', 'color' => 'teal'],
        ['label' => 'Revenue (Total)',   'value' => 'NPR '.number_format($revenueTotal),     'sub' => 'all time',   'color' => 'teal'],
    ] as $stat)
    <div class="card p-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $stat['label'] }}</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
        <p class="text-xs text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 mt-0.5">
            {{ $stat['sub'] }}
        </p>
    </div>
    @endforeach
</div>

{{-- Monthly chart --}}
<div class="card p-6 mb-6">
    <h2 class="font-semibold text-gray-900 dark:text-white mb-6">
        Growth — Last 6 Months
    </h2>
    <div class="flex items-end gap-4 h-40">
        @foreach($monthlySignups as $month)
        <div class="flex-1 flex flex-col items-center gap-1">
            <div class="w-full flex gap-1 items-end h-32">
                <div class="flex-1 bg-brand-500 dark:bg-brand-600 rounded-t transition-all"
                     style="height: {{ $monthlySignups->max('companies') > 0 ? round(($month['companies'] / max($monthlySignups->max('companies'), 1)) * 100) : 0 }}%"
                     title="{{ $month['companies'] }} companies">
                </div>
                <div class="flex-1 bg-green-400 dark:bg-green-600 rounded-t transition-all"
                     style="height: {{ $monthlySignups->max('jobs') > 0 ? round(($month['jobs'] / max($monthlySignups->max('jobs'), 1)) * 100) : 0 }}%"
                     title="{{ $month['jobs'] }} jobs">
                </div>
            </div>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $month['month'] }}</span>
        </div>
        @endforeach
    </div>
    <div class="flex gap-4 mt-3 text-xs text-gray-500 dark:text-gray-400">
        <span class="flex items-center gap-1.5">
            <span class="w-3 h-3 bg-brand-500 rounded-sm inline-block"></span>
            Companies
        </span>
        <span class="flex items-center gap-1.5">
            <span class="w-3 h-3 bg-green-400 rounded-sm inline-block"></span>
            Jobs
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Recent Companies --}}
    <div class="card">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-white">Recent Companies</h2>
            <a href="{{ route('admin.companies.index') }}"
               class="text-xs text-brand-600 dark:text-brand-400 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @foreach($recentCompanies as $company)
            <div class="px-5 py-3 flex items-center gap-3">
                <img src="{{ $company->logoUrl() }}" alt="{{ $company->name }}"
                     class="w-9 h-9 rounded-lg object-cover border border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <a href="{{ route('admin.companies.show', $company->id) }}"
                       class="text-sm font-medium text-gray-900 dark:text-white hover:text-brand-600 truncate block">
                        {{ $company->name }}
                    </a>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $company->industry }}</p>
                </div>
                <div class="flex flex-col items-end gap-1 flex-shrink-0">
                    @php
                        $statusClass = match($company->subscription_status) {
                            'active'  => 'badge-green',
                            'trial'   => 'badge-yellow',
                            'expired' => 'badge-red',
                            default   => 'badge-gray',
                        };
                    @endphp
                    <span class="{{ $statusClass }}">{{ ucfirst($company->subscription_status) }}</span>
                    <span class="text-xs text-gray-400">{{ $company->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Recent Subscriptions --}}
    <div class="card">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-white">Recent Subscriptions</h2>
            <a href="{{ route('admin.subscriptions.index') }}"
               class="text-xs text-brand-600 dark:text-brand-400 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($recentSubscriptions as $sub)
            <div class="px-5 py-3 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ $sub->company->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $sub->plan->name }} · {{ ucfirst($sub->billing_cycle) }}
                    </p>
                </div>
                <div class="flex flex-col items-end gap-1 flex-shrink-0">
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                        NPR {{ number_format($sub->amount_paid) }}
                    </span>
                    @php
                        $subClass = match($sub->status) {
                            'active'  => 'badge-green',
                            'pending' => 'badge-yellow',
                            default   => 'badge-gray',
                        };
                    @endphp
                    <span class="{{ $subClass }}">{{ ucfirst($sub->status) }}</span>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-sm text-gray-400">No subscriptions yet.</div>
            @endforelse
        </div>
    </div>

</div>

@endsection
