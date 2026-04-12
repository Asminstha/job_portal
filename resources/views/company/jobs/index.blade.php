@extends('layouts.app')
@section('title', 'Job Listings')
@section('page-title', 'Job Listings')
@section('page-subtitle', 'Manage all your posted jobs')

@section('content')

<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        {{ $jobs->total() }} {{ Str::plural('job', $jobs->total()) }} total
    </p>
    <a href="{{ route('company.jobs.create') }}" class="btn-primary">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Post New Job
    </a>
</div>

<div class="card overflow-hidden">
    @if($jobs->isNotEmpty())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800
                           bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 dark:text-gray-400 uppercase tracking-wider">Job Title</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Type</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Applications</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Posted</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($jobs as $job)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="px-5 py-4">
                        <div class="font-medium text-gray-900 dark:text-white">{{ $job->title }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            {{ $job->locationLabel() }} · {{ $job->salaryDisplay() }}
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <span class="badge badge-blue">{{ $job->typeLabel() }}</span>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell">
                        <a href="{{ route('company.applications.index', $job->id) }}"
                           class="text-brand-600 dark:text-brand-400 hover:underline font-medium">
                            {{ $job->applications_count }}
                            {{ Str::plural('application', $job->applications_count) }}
                        </a>
                    </td>
                    <td class="px-5 py-4">
                        @php
                            $statusClass = match($job->status) {
                                'active'  => 'badge-green',
                                'draft'   => 'badge-gray',
                                'paused'  => 'badge-yellow',
                                'closed'  => 'badge-red',
                                'expired' => 'badge-red',
                                default   => 'badge-gray',
                            };
                        @endphp
                        <span class="{{ $statusClass }}">{{ ucfirst($job->status) }}</span>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-gray-500 dark:text-gray-400 text-xs">
                        {{ optional($job->published_at ?? $job->created_at)->format('M d, Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('jobs.show', $job->slug) }}"
                               target="_blank"
                               class="text-xs text-gray-400 hover:text-gray-600
                                      dark:hover:text-gray-300 transition-colors"
                               title="View public listing">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0
                                             002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>

                            {{-- Toggle status --}}
                            <form method="POST" action="{{ route('company.jobs.toggle', $job->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="text-xs px-2.5 py-1 rounded-lg border transition-colors
                                               {{ $job->status === 'active'
                                                    ? 'border-yellow-300 text-yellow-700 hover:bg-yellow-50 dark:border-yellow-700 dark:text-yellow-400'
                                                    : 'border-green-300 text-green-700 hover:bg-green-50 dark:border-green-700 dark:text-green-400' }}">
                                    {{ $job->status === 'active' ? 'Pause' : 'Activate' }}
                                </button>
                            </form>

                            <a href="{{ route('company.jobs.edit', $job->id) }}"
                               class="btn-secondary text-xs py-1 px-2.5">Edit</a>

                            <form method="POST" action="{{ route('company.jobs.destroy', $job->id) }}"
                                  onsubmit="return confirm('Delete this job? This cannot be undone.')">
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
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        {{ $jobs->links() }}
    </div>
    @else
    <div class="py-16 text-center">
        <div class="text-5xl mb-4">💼</div>
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No jobs posted yet</h3>
        <p class="text-gray-400 dark:text-gray-500 text-sm mb-5">
            Create your first job listing to start receiving applications.
        </p>
        <a href="{{ route('company.jobs.create') }}" class="btn-primary">Post Your First Job</a>
    </div>
    @endif
</div>

@endsection
