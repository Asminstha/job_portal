@extends('layouts.admin')
@section('title', 'Job Listings')
@section('page-title', 'All Job Listings')
@section('page-subtitle', 'Manage all jobs on the platform')

@section('content')

<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="q" value="{{ request('q') }}"
           class="form-input flex-1 min-w-48" placeholder="Search title or company...">
    <select name="status" class="form-input w-36">
        <option value="">All statuses</option>
        <option value="active"  {{ request('status') === 'active'  ? 'selected' : '' }}>Active</option>
        <option value="draft"   {{ request('status') === 'draft'   ? 'selected' : '' }}>Draft</option>
        <option value="paused"  {{ request('status') === 'paused'  ? 'selected' : '' }}>Paused</option>
        <option value="closed"  {{ request('status') === 'closed'  ? 'selected' : '' }}>Closed</option>
        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
    </select>
    <button type="submit" class="btn-primary">Search</button>
    @if(request()->anyFilled(['q','status']))
        <a href="{{ route('admin.jobs.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Job</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Company</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Applications</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Posted</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($jobs as $job)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $job->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $job->typeLabel() }} · {{ $job->locationLabel() }}
                        </p>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <a href="{{ route('admin.companies.show', $job->company) }}"
                           class="text-sm text-brand-600 dark:text-brand-400 hover:underline">
                            {{ $job->company->name }}
                        </a>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-gray-700 dark:text-gray-300">
                        {{ $job->applications_count }}
                    </td>
                    <td class="px-5 py-4">
                        @php
                            $jClass = match($job->status) {
                                'active'  => 'badge-green',
                                'draft'   => 'badge-gray',
                                'paused'  => 'badge-yellow',
                                default   => 'badge-red',
                            };
                        @endphp
                        <span class="{{ $jClass }}">{{ ucfirst($job->status) }}</span>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-xs text-gray-500 dark:text-gray-400">
                        {{ optional($job->published_at ?? $job->created_at)->format('M d, Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('jobs.show', $job->slug) }}" target="_blank"
                               class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.jobs.toggle', $job->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="text-xs px-2.5 py-1 rounded-lg border transition-colors
                                               {{ $job->status === 'active'
                                                   ? 'border-yellow-300 text-yellow-700 hover:bg-yellow-50 dark:border-yellow-700 dark:text-yellow-400'
                                                   : 'border-green-300 text-green-700 hover:bg-green-50 dark:border-green-700 dark:text-green-400' }}">
                                    {{ $job->status === 'active' ? 'Pause' : 'Activate' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.jobs.destroy', $job->id) }}"
                                  onsubmit="return confirm('Delete this job permanently?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs px-2.5 py-1 rounded-lg border border-red-200
                                               text-red-600 hover:bg-red-50 dark:border-red-800
                                               dark:text-red-400 dark:hover:bg-red-900/20 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">No jobs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        {{ $jobs->links() }}
    </div>
</div>

@endsection
