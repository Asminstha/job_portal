<div class="card p-5 hover:shadow-md hover:border-gray-300 dark:hover:border-gray-700 transition-all group">
    <div class="flex items-start gap-4">

        {{-- Company Logo --}}
        <a href="{{ route('companies.show', $job->company->slug) }}" class="flex-shrink-0">
            <img src="{{ $job->company->logoUrl() }}"
                 alt="{{ $job->company->name }}"
                 class="w-12 h-12 rounded-lg object-cover border border-gray-200 dark:border-gray-700">
        </a>

        {{-- Job Info --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <a href="{{ route('jobs.show', $job->slug) }}"
                       class="text-base font-semibold text-gray-900 dark:text-white
                              group-hover:text-brand-600 dark:group-hover:text-brand-400
                              transition-colors line-clamp-1 block">
                        {{ $job->title }}
                    </a>
                    <a href="{{ route('companies.show', $job->company->slug) }}"
                       class="text-sm text-gray-500 dark:text-gray-400
                              hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        {{ $job->company->name }}
                    </a>
                </div>
                @if($job->is_featured)
                    <span class="badge badge-yellow flex-shrink-0">Featured</span>
                @endif
            </div>

            {{-- Meta info --}}
            <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-gray-500 dark:text-gray-400">

                {{-- Location --}}
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827
                                 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $job->locationLabel() }}
                </span>

                {{-- Job type --}}
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $job->typeLabel() }}
                </span>

                {{-- Salary --}}
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3
                                 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0
                                 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9
                                 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $job->salaryDisplay() }}
                </span>

                {{-- Category badge --}}
                @if($job->category)
                    <span class="badge badge-blue">{{ $job->category->name }}</span>
                @endif

            </div>
        </div>

        {{-- Right side: date + button --}}
        <div class="hidden sm:flex flex-col items-end gap-2 flex-shrink-0">
            <span class="text-xs text-gray-400 dark:text-gray-500 whitespace-nowrap">
                {{ optional($job->published_at ?? $job->created_at)->diffForHumans() }}
            </span>
            <a href="{{ route('jobs.show', $job->slug) }}"
               class="btn-primary text-xs px-3 py-1.5 whitespace-nowrap">
                View Job
            </a>
        </div>

    </div>
</div>
