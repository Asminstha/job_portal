@extends('layouts.public')
@section('seo')
    <x-seo
        title="{{ $company->name }} Jobs & Profile — JobsNepal"
        description="{{ $company->description ? Str::limit($company->description, 140) : 'View open positions at '.$company->name.' on JobsNepal.' }}"
        image="{{ $company->logo ? asset('storage/'.$company->logo) : null }}"
    />
@endsection
@section('title', $company->name . ' — Jobs & Company Profile')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-brand-600">Home</a>
        <span>/</span>
        <a href="{{ route('companies.index') }}" class="hover:text-brand-600">Companies</a>
        <span>/</span>
        <span class="text-gray-700 dark:text-gray-300">{{ $company->name }}</span>
    </nav>

    {{-- Company Header --}}
    <div class="card p-8 mb-8">
        <div class="flex flex-col sm:flex-row items-start gap-6">
            <img src="{{ $company->logoUrl() }}" alt="{{ $company->name }}"
                 class="w-20 h-20 rounded-2xl object-cover
                        border border-gray-200 dark:border-gray-700 flex-shrink-0">
            <div class="flex-1 min-w-0">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $company->name }}
                        </h1>
                        <p class="text-brand-600 dark:text-brand-400 font-medium text-sm mt-0.5">
                            {{ $company->industry }}
                        </p>
                    </div>
                    <span class="badge badge-green text-sm px-3 py-1">
                        {{ $jobs->total() }} Open {{ Str::plural('Position', $jobs->total()) }}
                    </span>
                </div>

                <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500 dark:text-gray-400">
                    @if($company->city)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827
                                         0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            {{ $company->city }}, {{ $company->country }}
                        </span>
                    @endif
                    @if($company->size)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $company->size }} employees
                        </span>
                    @endif
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-1.5 text-brand-600 dark:text-brand-400 hover:underline">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0
                                         002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Visit Website
                        </a>
                    @endif
                </div>

                @if($company->description)
                    <p class="mt-4 text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        {{ $company->description }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Open Positions --}}
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-5">
            Open Positions
            <span class="text-base font-normal text-gray-400 ml-1">({{ $jobs->total() }})</span>
        </h2>

        @if($jobs->isNotEmpty())
            <div class="space-y-3">
                @foreach($jobs as $job)
                    @include('components.job-card', ['job' => $job])
                @endforeach
            </div>
            <div class="mt-6">{{ $jobs->links() }}</div>
        @else
            <div class="card p-10 text-center">
                <div class="text-4xl mb-3">📭</div>
                <p class="text-gray-500 dark:text-gray-400">
                    No open positions right now. Check back soon!
                </p>
            </div>
        @endif
    </div>

</div>
@endsection
