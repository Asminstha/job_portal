@extends('layouts.public')
@section('title', $job->title . ' at ' . $job->company->name)

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">Home</a>
            <span>/</span>
            <a href="{{ route('jobs.index') }}" class="hover:text-brand-600 transition-colors">Jobs</a>
            <span>/</span>
            <span class="text-gray-700 dark:text-gray-300 truncate">{{ $job->title }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Left: Main content --}}
            <div class="flex-1 min-w-0 space-y-6">

                {{-- Job Header Card --}}
                <div class="card p-6">
                    <div class="flex items-start gap-5">
                        <img src="{{ $job->company->logoUrl() }}" alt="{{ $job->company->name }}"
                            class="w-16 h-16 rounded-xl object-cover
                                border border-gray-200 dark:border-gray-700 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <h1 class="text-xl font-bold text-gray-900 dark:text-white leading-tight">
                                        {{ $job->title }}
                                    </h1>
                                    <a href="{{ route('companies.show', $job->company->slug) }}"
                                        class="text-brand-600 dark:text-brand-400
                                          hover:underline text-sm font-medium mt-0.5 block">
                                        {{ $job->company->name }}
                                    </a>
                                </div>
                                @if ($job->is_featured)
                                    <span class="badge badge-yellow">⭐ Featured</span>
                                @endif
                            </div>

                            {{-- Badges --}}
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="badge badge-blue">{{ $job->typeLabel() }}</span>
                                <span class="badge badge-gray">{{ $job->locationLabel() }}</span>
                                @if ($job->category)
                                    <span class="badge badge-purple">{{ $job->category->name }}</span>
                                @endif
                            </div>

                            {{-- Key stats --}}
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-4">
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 text-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Salary</div>
                                    <div class="text-xs font-semibold text-gray-900 dark:text-white leading-tight">
                                        {{ $job->salaryDisplay() }}
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 text-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Experience</div>
                                    <div class="text-xs font-semibold text-gray-900 dark:text-white">
                                        {{ $job->experience_min }}+ years
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 text-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Applicants</div>
                                    <div class="text-xs font-semibold text-gray-900 dark:text-white">
                                        {{ number_format($job->applications_count) }}
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-3 text-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Posted</div>
                                    <div class="text-xs font-semibold text-gray-900 dark:text-white">
                                        {{ optional($job->published_at ?? $job->created_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="card p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Job Description</h2>
                    <div
                        class="prose prose-sm dark:prose-invert max-w-none
                            text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                @if ($job->requirements)
                    <div class="card p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Requirements</h2>
                        <div
                            class="prose prose-sm dark:prose-invert max-w-none
                            text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($job->requirements)) !!}
                        </div>
                    </div>
                @endif

                @if ($job->benefits)
                    <div class="card p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Benefits & Perks</h2>
                        <div
                            class="prose prose-sm dark:prose-invert max-w-none
                            text-gray-700 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($job->benefits)) !!}
                        </div>
                    </div>
                @endif

                {{-- Related Jobs --}}
                @if ($relatedJobs->isNotEmpty())
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Similar Jobs</h2>
                        <div class="space-y-3">
                            @foreach ($relatedJobs as $related)
                                @include('components.job-card', ['job' => $related])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right: Sidebar --}}
            <div class="w-full lg:w-80 flex-shrink-0">
                <div class="sticky top-24 space-y-5">

                    {{-- Apply Box --}}
                    <div class="card p-6">
                        @if ($hasApplied)
                            {{-- Already applied --}}
                            <div class="text-center">
                                <div
                                    class="w-14 h-14 bg-green-100 dark:bg-green-900/40 rounded-full
                                        flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1
                                                 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0
                                                 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                    Application Submitted!
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    You applied for this position. Good luck!
                                </p>
                                <a href="{{ route('seeker.applications.index') }}"
                                    class="btn-secondary w-full justify-center text-sm">
                                    Track My Applications
                                </a>
                            </div>
                        @elseif(auth()->check() && auth()->user()->isSeeker())
                            {{-- Apply form --}}
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">
                                Apply for this Position
                            </h3>
                            <form method="POST" action="{{ route('jobs.apply', $job->slug) }}"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="form-label">Cover Letter
                                        <span class="text-gray-400 font-normal">(optional)</span>
                                    </label>
                                    <textarea name="cover_letter" rows="5" class="form-input resize-none text-sm"
                                        placeholder="Tell the employer why you're the perfect fit for this role...">{{ old('cover_letter') }}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Resume
                                        <span class="text-gray-400 font-normal">(optional)</span>
                                    </label>
                                    <input type="file" name="resume" accept=".pdf,.doc,.docx"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-3 file:py-2 file:px-3 file:rounded-lg
                                              file:border-0 file:text-xs file:font-medium
                                              file:bg-brand-50 file:text-brand-700
                                              dark:file:bg-brand-900 dark:file:text-brand-300
                                              hover:file:bg-brand-100 transition-colors cursor-pointer">
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                        PDF, DOC, DOCX — max 5MB
                                    </p>
                                </div>
                                @error('cover_letter')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                                @error('resume')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="btn-primary w-full justify-center py-3">
                                    Submit Application
                                </button>
                            </form>
                        @elseif(auth()->check() && auth()->user()->isCompanyMember())
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    You are logged in as an employer.<br>
                                    Only job seekers can apply.
                                </p>
                            </div>
                        @else
                            {{-- Not logged in --}}
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2">
                                Interested in this job?
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                Create a free account to apply in seconds.
                            </p>
                            <a href="{{ route('register.seeker') }}" class="btn-primary w-full justify-center mb-3">
                                Apply Now — Free
                            </a>
                            <a href="{{ route('login') }}" class="btn-secondary w-full justify-center text-sm">
                                Already have an account? Sign in
                            </a>
                        @endif

                        {{-- Save job button --}}
                        @auth
                            @if (auth()->user()->isSeeker())
                                <form method="POST" action="{{ route('seeker.saved.toggle', $job->id) }}" class="mt-3">
                                    @csrf
                                    <button type="submit"
                                        class="w-full justify-center btn-secondary text-sm flex items-center gap-2">
                                        @if ($isSaved)
                                            <svg class="w-4 h-4 text-brand-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M5 3a2 2 0 00-2 2v16l7-3.5L17 21V5a2 2 0 00-2-2H5z" />
                                            </svg>
                                            Saved — Click to Remove
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>
                                            Save Job
                                        @endif
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    {{-- Job Overview --}}
                    <div class="card p-6">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Job Overview</h3>
                        <div class="space-y-3">
                            @foreach ([['label' => 'Posted', 'value' => optional($job->published_at ?? $job->created_at)->format('M d, Y')], ['label' => 'Deadline', 'value' => $job->expires_at?->format('M d, Y') ?? 'Open until filled'], ['label' => 'Job Type', 'value' => $job->typeLabel()], ['label' => 'Work Mode', 'value' => ucfirst($job->location_type)], ['label' => 'Location', 'value' => $job->city ? $job->city . ', ' . $job->country : $job->country], ['label' => 'Salary', 'value' => $job->salaryDisplay()], ['label' => 'Experience', 'value' => $job->experience_min . '+ years']] as $item)
                                <div class="flex justify-between items-start gap-2 text-sm">
                                    <span class="text-gray-500 dark:text-gray-400 flex-shrink-0">
                                        {{ $item['label'] }}
                                    </span>
                                    <span class="text-gray-900 dark:text-white font-medium text-right">
                                        {{ $item['value'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Company Card --}}
                    <div class="card p-6">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">About the Company</h3>
                        <div class="flex items-center gap-3 mb-3">
                            <img src="{{ $job->company->logoUrl() }}" alt="{{ $job->company->name }}"
                                class="w-11 h-11 rounded-lg object-cover
                                    border border-gray-200 dark:border-gray-700">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">
                                    {{ $job->company->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $job->company->industry }}
                                </p>
                            </div>
                        </div>
                        @if ($job->company->description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-3">
                                {{ $job->company->description }}
                            </p>
                        @endif
                        <a href="{{ route('companies.show', $job->company->slug) }}"
                            class="btn-secondary w-full justify-center mt-4 text-sm">
                            View Company Profile
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
