@extends('layouts.admin')
@section('title', 'Companies')
@section('page-title', 'Companies')
@section('page-subtitle', 'Manage all registered companies')

@section('content')

{{-- Search + Filters --}}
<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="q" value="{{ request('q') }}"
           class="form-input flex-1 min-w-48" placeholder="Search name, email, industry...">
    <select name="status" class="form-input w-40">
        <option value="">All statuses</option>
        <option value="trial"     {{ request('status') === 'trial'     ? 'selected' : '' }}>Trial</option>
        <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Active</option>
        <option value="expired"   {{ request('status') === 'expired'   ? 'selected' : '' }}>Expired</option>
        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
    </select>
    <select name="active" class="form-input w-36">
        <option value="">All</option>
        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Active only</option>
        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Suspended</option>
    </select>
    <button type="submit" class="btn-primary">Search</button>
    @if(request()->anyFilled(['q','status','active']))
        <a href="{{ route('admin.companies.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Plan</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Jobs</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Joined</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($companies as $company)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors
                           {{ !$company->is_active ? 'opacity-60' : '' }}">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $company->logoUrl() }}" alt="{{ $company->name }}"
                                 class="w-9 h-9 rounded-lg object-cover border border-gray-200 dark:border-gray-700 flex-shrink-0">
                            <div>
                                <a href="{{ route('admin.companies.show', $company->id) }}"
                                   class="font-medium text-gray-900 dark:text-white hover:text-brand-600 block">
                                    {{ $company->name }}
                                </a>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $company->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                    class="text-xs text-gray-700 dark:text-gray-300
                                           hover:text-brand-600 font-medium flex items-center gap-1">
                                {{ $company->plan?->name ?? 'No Plan' }}
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open"
                                 class="absolute top-6 left-0 z-20 bg-white dark:bg-gray-900
                                        border border-gray-200 dark:border-gray-700
                                        rounded-xl shadow-lg py-2 min-w-36">
                                @foreach($plans as $plan)
                                <form method="POST"
                                      action="{{ route('admin.companies.plan', $company->id) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <button type="submit"
                                            class="w-full text-left px-4 py-2 text-xs
                                                   text-gray-700 dark:text-gray-300
                                                   hover:bg-gray-50 dark:hover:bg-gray-800
                                                   {{ $company->plan_id === $plan->id ? 'font-semibold text-brand-600 dark:text-brand-400' : '' }}">
                                        {{ $plan->name }}
                                    </button>
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell">
                        <span class="text-gray-700 dark:text-gray-300">{{ $company->jobs_count }}</span>
                    </td>
                    <td class="px-5 py-4">
                        @php
                            $statusClass = match($company->subscription_status) {
                                'active'    => 'badge-green',
                                'trial'     => 'badge-yellow',
                                'expired'   => 'badge-red',
                                'suspended' => 'badge-red',
                                default     => 'badge-gray',
                            };
                        @endphp
                        <div class="flex flex-col gap-1">
                            <span class="{{ $statusClass }}">{{ ucfirst($company->subscription_status) }}</span>
                            @if(!$company->is_active)
                                <span class="badge badge-red">Suspended</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-xs text-gray-500 dark:text-gray-400">
                        {{ $company->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.companies.show', $company->id) }}"
                               class="btn-secondary text-xs py-1 px-2.5">View</a>
                            <form method="POST"
                                  action="{{ route('admin.companies.toggle', $company->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="text-xs px-2.5 py-1 rounded-lg border transition-colors
                                               {{ $company->is_active
                                                   ? 'border-red-200 text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400'
                                                   : 'border-green-200 text-green-600 hover:bg-green-50 dark:border-green-800 dark:text-green-400' }}">
                                    {{ $company->is_active ? 'Suspend' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">No companies found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        {{ $companies->links() }}
    </div>
</div>

@endsection
