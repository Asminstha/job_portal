@extends('layouts.public')
@section('title', 'Companies Hiring in Nepal')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Companies Hiring Now</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            {{ number_format($companies->total()) }} companies actively posting jobs
        </p>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('companies.index') }}"
          class="flex flex-col sm:flex-row gap-3 mb-8">
        <input type="text" name="q" value="{{ request('q') }}"
               class="form-input flex-1" placeholder="Search company name or industry">
        <select name="industry" class="form-input sm:w-52">
            <option value="">All industries</option>
            @foreach($industries as $ind)
                <option value="{{ $ind }}" {{ request('industry') === $ind ? 'selected' : '' }}>
                    {{ $ind }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary px-6 whitespace-nowrap">Search</button>
        @if(request()->anyFilled(['q','industry']))
            <a href="{{ route('companies.index') }}" class="btn-secondary px-4 whitespace-nowrap">Clear</a>
        @endif
    </form>

    {{-- Company Grid --}}
    @if($companies->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($companies as $company)
                <a href="{{ route('companies.show', $company->slug) }}"
                   class="card p-5 hover:shadow-md hover:border-gray-300 dark:hover:border-gray-700
                          transition-all group block">
                    <div class="flex items-center gap-3 mb-3">
                        <img src="{{ $company->logoUrl() }}"
                             alt="{{ $company->name }}"
                             class="w-12 h-12 rounded-xl object-cover
                                    border border-gray-200 dark:border-gray-700 flex-shrink-0">
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm
                                       group-hover:text-brand-600 dark:group-hover:text-brand-400
                                       transition-colors truncate">
                                {{ $company->name }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ $company->industry }}
                            </p>
                        </div>
                    </div>

                    @if($company->description)
                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-3 leading-relaxed">
                            {{ $company->description }}
                        </p>
                    @endif

                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-1 text-gray-400 dark:text-gray-500">
                            @if($company->city)
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827
                                             0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $company->city }}
                            @endif
                        </div>
                        <span class="badge badge-blue">
                            {{ $company->jobs_count }} {{ Str::plural('job', $company->jobs_count) }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">{{ $companies->links() }}</div>
    @else
        <div class="card p-12 text-center">
            <div class="text-5xl mb-4">🏢</div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">No companies found</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Try adjusting your search.</p>
        </div>
    @endif
</div>
@endsection
