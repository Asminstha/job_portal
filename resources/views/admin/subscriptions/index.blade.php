@extends('layouts.admin')
@section('title', 'Subscriptions')
@section('page-title', 'Subscriptions & Revenue')
@section('page-subtitle', 'Manage all company subscriptions')

@section('content')

{{-- Revenue stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['label' => 'Total Revenue',    'value' => 'NPR ' . number_format($stats['total_revenue']),   'color' => 'green'],
        ['label' => 'This Month',       'value' => 'NPR ' . number_format($stats['this_month']),      'color' => 'teal'],
        ['label' => 'Pending Approval', 'value' => $stats['pending'],                                 'color' => 'yellow'],
        ['label' => 'Active Subs',      'value' => $stats['active'],                                  'color' => 'blue'],
    ] as $stat)
    <div class="card p-5">
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $stat['label'] }}</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Plan</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Amount</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Period</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($subscriptions as $sub)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $sub->company->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $sub->company->email }}
                        </p>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <p class="text-gray-700 dark:text-gray-300">{{ $sub->plan->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ ucfirst($sub->billing_cycle) }}
                        </p>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <p class="font-semibold text-gray-900 dark:text-white">
                            NPR {{ number_format($sub->amount_paid) }}
                        </p>
                        @if($sub->payment_method)
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                via {{ $sub->payment_method }}
                            </p>
                        @endif
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell text-xs text-gray-500 dark:text-gray-400">
                        @if($sub->current_period_start)
                            {{ $sub->current_period_start->format('M d') }}
                            –
                            {{ $sub->current_period_end?->format('M d, Y') }}
                        @else
                            <span class="text-gray-300">Not activated</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @php
                            $sClass = match($sub->status) {
                                'active'    => 'badge-green',
                                'pending'   => 'badge-yellow',
                                'cancelled' => 'badge-red',
                                'expired'   => 'badge-red',
                                default     => 'badge-gray',
                            };
                        @endphp
                        <span class="{{ $sClass }}">{{ ucfirst($sub->status) }}</span>
                    </td>
                    <td class="px-5 py-4">
                        @if($sub->status === 'pending')
                        <div class="flex gap-2">
                            <form method="POST"
                                  action="{{ route('admin.subscriptions.approve', $sub) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="text-xs px-2.5 py-1 rounded-lg border
                                               border-green-300 text-green-700 hover:bg-green-50
                                               dark:border-green-700 dark:text-green-400
                                               transition-colors">
                                    Approve
                                </button>
                            </form>
                            <form method="POST"
                                  action="{{ route('admin.subscriptions.reject', $sub) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="text-xs px-2.5 py-1 rounded-lg border
                                               border-red-200 text-red-600 hover:bg-red-50
                                               dark:border-red-800 dark:text-red-400
                                               transition-colors">
                                    Reject
                                </button>
                            </form>
                        </div>
                        @else
                        <span class="text-xs text-gray-400">{{ $sub->created_at->format('M d, Y') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">No subscriptions yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        {{ $subscriptions->links() }}
    </div>
</div>

@endsection
