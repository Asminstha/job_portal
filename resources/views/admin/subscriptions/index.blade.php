@extends('layouts.admin')
@section('title', 'Subscriptions')
@section('page-title', 'Subscriptions & Revenue')
@section('page-subtitle', 'Manage all company subscriptions')

@section('content')

    {{-- Revenue stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ([['label' => 'Total Revenue', 'value' => 'NPR ' . number_format($stats['total_revenue']), 'color' => 'green'], ['label' => 'This Month', 'value' => 'NPR ' . number_format($stats['this_month']), 'color' => 'teal'], ['label' => 'Pending Approval', 'value' => $stats['pending'], 'color' => 'yellow'], ['label' => 'Active Subs', 'value' => $stats['active'], 'color' => 'blue']] as $stat)
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
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Company
                        </th>
                        <th
                            class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Plan</th>
                        <th
                            class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Amount</th>
                        <th
                            class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Payment Proof
                        </th>
                        <th
                            class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Period</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status
                        </th>
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
                                @if ($sub->payment_method)
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        via {{ $sub->payment_method }}
                                    </p>
                                @endif
                                @if ($sub->payment_reference)
                                    <p class="text-xs text-gray-400 font-mono">
                                        Ref: {{ $sub->payment_reference }}
                                    </p>
                                @endif
                            </td>

                            {{-- Payment Proof column --}}
                            <td class="px-5 py-4 hidden lg:table-cell">
                                @if ($sub->payment_proof)
                                    @php
                                        $ext = pathinfo($sub->payment_proof, PATHINFO_EXTENSION);
                                        $isPdf = strtolower($ext) === 'pdf';
                                    @endphp
                                    @if ($isPdf)
                                        <a href="{{ asset('storage/' . $sub->payment_proof) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 text-xs text-brand-600
                              dark:text-brand-400 hover:underline font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                                         012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0
                                         01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            View PDF
                                        </a>
                                    @else
                                        {{-- Image proof with preview popup --}}
                                        <div x-data="{ open: false }">
                                            <button @click="open = true" class="group relative block">
                                                <img src="{{ asset('storage/' . $sub->payment_proof) }}"
                                                    alt="Payment proof"
                                                    class="w-16 h-12 object-cover rounded-lg border
                                        border-gray-200 dark:border-gray-700
                                        group-hover:opacity-75 transition-opacity cursor-pointer">
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center
                                        opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-5 h-5 text-white drop-shadow-lg" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                    </svg>
                                                </div>
                                            </button>

                                            {{-- Full size image modal --}}
                                            <div x-show="open" @click.self="open = false"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                style="position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.8);
                                    display:flex;align-items:center;justify-content:center;padding:16px"
                                                x-cloak>
                                                <div class="relative max-w-2xl w-full">
                                                    <button @click="open = false"
                                                        style="position:absolute;top:-40px;right:0;color:white;
                                               font-size:14px;padding:8px 16px;
                                               background:rgba(255,255,255,0.1);
                                               border-radius:8px;border:none;cursor:pointer">
                                                        Close ✕
                                                    </button>
                                                    <img src="{{ asset('storage/' . $sub->payment_proof) }}"
                                                        alt="Payment proof - {{ $sub->company->name }}"
                                                        style="width:100%;border-radius:12px;
                                            border:2px solid rgba(255,255,255,0.2)">
                                                    <div
                                                        style="text-align:center;margin-top:12px;color:white;font-size:13px">
                                                        {{ $sub->company->name }} —
                                                        NPR {{ number_format($sub->amount_paid) }} via
                                                        {{ $sub->payment_method }}
                                                        @if ($sub->payment_reference)
                                                            (Ref: {{ $sub->payment_reference }})
                                                        @endif
                                                    </div>
                                                    <div style="text-align:center;margin-top:8px">
                                                        <a href="{{ asset('storage/' . $sub->payment_proof) }}"
                                                            target="_blank"
                                                            style="color:#93c5fd;font-size:12px;text-decoration:underline">
                                                            Open full size in new tab
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400 italic">No proof uploaded</span>
                                @endif
                            </td>

                            <td class="px-5 py-4 hidden lg:table-cell text-xs text-gray-500 dark:text-gray-400">
                                @if ($sub->current_period_start)
                                    {{ $sub->current_period_start->format('M d') }}
                                    –
                                    {{ $sub->current_period_end?->format('M d, Y') }}
                                @else
                                    <span class="text-gray-300 dark:text-gray-600">Not activated</span>
                                @endif
                            </td>

                            <td class="px-5 py-4">
                                @php
                                    $sClass = match ($sub->status) {
                                        'active' => 'badge-green',
                                        'pending' => 'badge-yellow',
                                        'cancelled' => 'badge-red',
                                        'expired' => 'badge-red',
                                        default => 'badge-gray',
                                    };
                                @endphp
                                <span class="{{ $sClass }}">{{ ucfirst($sub->status) }}</span>
                            </td>

                            <td class="px-5 py-4">
                                @if ($sub->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.subscriptions.approve', $sub->id) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="text-xs px-2.5 py-1 rounded-lg border
                                   border-green-300 text-green-700 hover:bg-green-50
                                   dark:border-green-700 dark:text-green-400
                                   transition-colors">
                                                Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.subscriptions.reject', $sub->id) }}">
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
                                    <span class="text-xs text-gray-400">
                                        {{ $sub->created_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                                No subscriptions yet.
                            </td>
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
