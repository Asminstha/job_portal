@extends('layouts.app')
@section('title', 'Applications')
@section('page-title', $job ? 'Applications for: ' . $job->title : 'All Applications')

@section('content')

{{-- Status tabs --}}
<div class="flex flex-wrap gap-2 mb-6">
    @php
        $statuses = ['all' => 'All', 'pending' => 'Pending', 'reviewed' => 'Reviewed',
                     'shortlisted' => 'Shortlisted', 'interview' => 'Interview',
                     'offered' => 'Offered', 'hired' => 'Hired', 'rejected' => 'Rejected'];
    @endphp
    @foreach($statuses as $val => $label)
        @php $count = $val === 'all' ? $statusCounts->sum() : ($statusCounts[$val] ?? 0); @endphp
        <a href="{{ request()->fullUrlWithQuery(['status' => $val === 'all' ? null : $val]) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                  border transition-colors
                  {{ request('status', 'all') === $val
                      ? 'bg-brand-600 text-white border-brand-600'
                      : 'bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-400 border-gray-300 dark:border-gray-700 hover:border-brand-400' }}">
            {{ $label }}
            @if($count > 0)
                <span class="px-1.5 py-0.5 rounded-full text-xs
                             {{ request('status', 'all') === $val ? 'bg-white/20 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400' }}">
                    {{ $count }}
                </span>
            @endif
        </a>
    @endforeach
</div>

{{-- Filter by job --}}
@if(!$job)
<div class="mb-4">
    <form method="GET" class="flex gap-3">
        <select name="job_id" class="form-input w-64"
                onchange="window.location.href='{{ route('company.applications.index', '') }}/' + this.value + '{{ request()->has('status') ? '?status=' . request('status') : '' }}'">
            <option value="all">All Jobs</option>
            @foreach($jobs as $j)
                <option value="{{ $j->id }}">{{ $j->title }}</option>
            @endforeach
        </select>
    </form>
</div>
@endif

{{-- Applications list --}}
<div class="card overflow-hidden">
    @if($applications->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Candidate</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Job</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Applied</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($applications as $app)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors
                               {{ !$app->read_at ? 'bg-blue-50/30 dark:bg-blue-900/10' : '' }}">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-brand-100 dark:bg-brand-900
                                            flex items-center justify-center
                                            text-brand-700 dark:text-brand-300 font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($app->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $app->user->name }}
                                        @if(!$app->read_at)
                                            <span class="ml-1.5 inline-block w-2 h-2 bg-brand-500 rounded-full"></span>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $app->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 hidden md:table-cell">
                            <span class="text-gray-700 dark:text-gray-300">{{ $app->job->title ?? '—' }}</span>
                        </td>
                        <td class="px-5 py-4">
                            {{-- Inline status update --}}
                            <form method="POST"
                                  action="{{ route('company.applications.status', $app->id) }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                        class="text-xs rounded-lg border px-2 py-1 font-medium
                                               bg-white dark:bg-gray-800
                                               border-gray-300 dark:border-gray-600
                                               text-gray-700 dark:text-gray-300
                                               focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                                    @foreach(['pending','reviewed','shortlisted','interview','offered','hired','rejected','withdrawn'] as $s)
                                        <option value="{{ $s }}" {{ $app->status === $s ? 'selected' : '' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-5 py-4 hidden lg:table-cell text-xs text-gray-500 dark:text-gray-400">
                            {{ $app->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('company.applications.show', [$app->job_id, $app->id]) }}"
                               class="btn-secondary text-xs py-1 px-2.5 whitespace-nowrap">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $applications->links() }}
        </div>
    @else
        <div class="py-16 text-center">
            <div class="text-5xl mb-4">📭</div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No applications yet</h3>
            <p class="text-sm text-gray-400 dark:text-gray-500">
                Applications will appear here when candidates apply to your jobs.
            </p>
        </div>
    @endif
</div>

@endsection
