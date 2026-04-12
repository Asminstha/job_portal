@extends('layouts.seeker')
@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Keep your profile up to date to attract employers')

@section('content')

    <form method="POST" action="{{ route('seeker.profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Main profile --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Basic Info --}}
                <div class="card p-6">
                    <h2 class="font-semibold text-gray-900 dark:text-white mb-5">
                        Basic Information
                    </h2>

                    {{-- Avatar Upload --}}
                    <div class="card p-6">
                        <h2 class="font-semibold text-gray-900 dark:text-white mb-5">Profile Photo</h2>
                        <div class="flex items-center gap-5">

                            {{-- Current avatar --}}
                            <div class="relative flex-shrink-0">
                                <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}"
                                    id="avatar-preview"
                                    class="w-20 h-20 rounded-full object-cover
                        border-2 border-gray-200 dark:border-gray-700">
                            </div>

                            <div class="flex-1">
                                <label class="form-label">Upload Photo</label>
                                <input type="file" name="avatar" accept="image/*" id="avatar-input"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                          file:mr-3 file:py-2 file:px-3 file:rounded-lg
                          file:border-0 file:text-xs file:font-medium
                          file:bg-purple-50 file:text-purple-700
                          dark:file:bg-purple-900 dark:file:text-purple-300
                          hover:file:bg-purple-100 transition-colors cursor-pointer">
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">
                                    JPG, PNG, GIF — max 2MB. Square photo recommended.
                                </p>
                                @error('avatar')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-input @error('name') border-red-500 @enderror" placeholder="Ram Bahadur Thapa">
                            @error('name')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input"
                                placeholder="+977 98XXXXXXXX">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="form-label">Professional Headline</label>
                            <input type="text" name="headline" value="{{ old('headline', $profile->headline) }}"
                                class="form-input" placeholder="e.g. Senior Laravel Developer | 5 Years Experience">
                            <p class="text-xs text-gray-400 mt-1">
                                This appears below your name on your profile
                            </p>
                        </div>
                        <div>
                            <label class="form-label">Location</label>
                            <input type="text" name="location" value="{{ old('location', $profile->location) }}"
                                class="form-input" placeholder="Kathmandu, Nepal">
                        </div>
                        <div>
                            <label class="form-label">Availability</label>
                            <select name="availability" class="form-input">
                                @foreach ([
            'immediate' => 'Immediately Available',
            '1_month' => 'Available in 1 Month',
            '3_months' => 'Available in 3 Months',
            'not_looking' => 'Not Looking Right Now',
        ] as $val => $label)
                                    <option value="{{ $val }}"
                                        {{ old('availability', $profile->availability) === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="card p-6">
                    <h2 class="font-semibold text-gray-900 dark:text-white mb-4">
                        Professional Summary
                    </h2>
                    <textarea name="summary" rows="5" class="form-input resize-y"
                        placeholder="Write a short summary about yourself, your skills, and what kind of opportunities you're looking for...">{{ old('summary', $profile->summary) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Max 2000 characters</p>
                </div>

                {{-- Skills --}}
                <div class="card p-6">
                    <h2 class="font-semibold text-gray-900 dark:text-white mb-2">Skills</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Enter your skills separated by commas
                    </p>

                    @php
                        $currentSkills = is_array($profile->skills)
                            ? implode(', ', $profile->skills)
                            : old('skills') ?? '';
                    @endphp

                    <input type="text" name="skills" value="{{ $currentSkills }}" class="form-input"
                        placeholder="Laravel, PHP, MySQL, Vue.js, Git, REST API">

                    {{-- Live skill preview --}}
                    <div x-data="{ skills: '{{ $currentSkills }}' }" class="mt-3">
                        <input type="hidden" name="skills_preview">
                        <div class="flex flex-wrap gap-1.5">
                            <template x-for="skill in skills.split(',').map(s => s.trim()).filter(s => s)"
                                :key="skill">
                                <span
                                    class="px-2.5 py-1 bg-brand-50 dark:bg-brand-900/40
                                         text-brand-700 dark:text-brand-300
                                         rounded-lg text-xs font-medium"
                                    x-text="skill"></span>
                            </template>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">
                        Preview updates as you type above
                    </p>
                </div>

                {{-- Links --}}
                <div class="card p-6">
                    <h2 class="font-semibold text-gray-900 dark:text-white mb-5">
                        Online Profiles
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">LinkedIn URL</label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2
                                         text-gray-400 text-sm">in</span>
                                <input type="url" name="linkedin_url"
                                    value="{{ old('linkedin_url', $profile->linkedin_url) }}" class="form-input pl-8"
                                    placeholder="https://linkedin.com/in/yourname">
                            </div>
                            @error('linkedin_url')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Portfolio / Website</label>
                            <input type="url" name="portfolio_url"
                                value="{{ old('portfolio_url', $profile->portfolio_url) }}" class="form-input"
                                placeholder="https://yourportfolio.com">
                            @error('portfolio_url')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">GitHub</label>
                            <input type="url" name="github_url"
                                value="{{ old('github_url', $profile->github_url) }}" class="form-input"
                                placeholder="https://github.com/yourusername">
                            @error('github_url')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right: Experience, salary, resume --}}
            <div class="space-y-5">

                {{-- Resume --}}
                <div class="card p-6">
                    <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Resume / CV</h2>

                    @if ($profile->resume_path)
                        <div
                            class="flex items-center gap-3 p-3 bg-green-50 dark:bg-green-900/30
                                border border-green-200 dark:border-green-700
                                rounded-lg mb-4">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                                             012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0
                                             01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                    Resume uploaded
                                </p>
                                <a href="{{ asset('storage/' . $profile->resume_path) }}" target="_blank"
                                    class="text-xs text-green-600 dark:text-green-400 hover:underline">
                                    View current resume
                                </a>
                            </div>
                        </div>
                    @endif

                    <label class="form-label">
                        {{ $profile->resume_path ? 'Replace Resume' : 'Upload Resume' }}
                    </label>
                    <input type="file" name="resume" accept=".pdf,.doc,.docx"
                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                              file:mr-3 file:py-2 file:px-3 file:rounded-lg
                              file:border-0 file:text-xs file:font-medium
                              file:bg-brand-50 file:text-brand-700
                              dark:file:bg-brand-900 dark:file:text-brand-300
                              hover:file:bg-brand-100 transition-colors cursor-pointer">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">
                        PDF, DOC, DOCX — max 5MB
                    </p>
                    @error('resume')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Experience --}}
                <div class="card p-6">
                    <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Experience</h2>
                    <div>
                        <label class="form-label">Years of Experience</label>
                        <select name="experience_years" class="form-input">
                            @foreach (range(0, 20) as $yr)
                                <option value="{{ $yr }}"
                                    {{ old('experience_years', $profile->experience_years ?? 0) == $yr ? 'selected' : '' }}>
                                    {{ $yr === 0 ? 'Fresher (0 years)' : $yr . ' ' . Str::plural('year', $yr) }}
                                </option>
                            @endforeach
                            <option value="21"
                                {{ old('experience_years', $profile->experience_years ?? 0) > 20 ? 'selected' : '' }}>
                                20+ years
                            </option>
                        </select>
                    </div>
                </div>

                {{-- Salary --}}
                <div class="card p-6">
                    <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Salary</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="form-label">Current Salary (NPR/month)</label>
                            <input type="number" name="current_salary"
                                value="{{ old('current_salary', $profile->current_salary) }}" class="form-input"
                                placeholder="60000">
                        </div>
                        <div>
                            <label class="form-label">Expected Salary (NPR/month)</label>
                            <input type="number" name="expected_salary"
                                value="{{ old('expected_salary', $profile->expected_salary) }}" class="form-input"
                                placeholder="80000">
                        </div>
                        <div>
                            <label class="form-label">Notice Period (days)</label>
                            <input type="number" name="notice_period_days"
                                value="{{ old('notice_period_days', $profile->notice_period_days ?? 30) }}"
                                class="form-input" placeholder="30">
                        </div>
                    </div>
                </div>

                {{-- Save button --}}
                <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
                    Save Profile
                </button>

                {{-- Profile completeness --}}
                <div class="card p-5">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                            Profile Strength
                        </h3>
                        <span class="text-sm font-bold text-brand-600 dark:text-brand-400">
                            {{ auth()->user()->seekerProfile ? '↑ Good' : 'Incomplete' }}
                        </span>
                    </div>
                    <ul class="space-y-1.5 text-xs text-gray-500 dark:text-gray-400">
                        @foreach ([['check' => $user->name, 'label' => 'Full name added'], ['check' => $user->phone, 'label' => 'Phone number added'], ['check' => $profile->headline, 'label' => 'Headline written'], ['check' => $profile->summary, 'label' => 'Summary written'], ['check' => $profile->skills && count($profile->skills ?? []), 'label' => 'Skills listed'], ['check' => $profile->resume_path, 'label' => 'Resume uploaded'], ['check' => $profile->linkedin_url, 'label' => 'LinkedIn added'], ['check' => $profile->location, 'label' => 'Location set']] as $item)
                            <li class="flex items-center gap-2">
                                @if ($item['check'])
                                    <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0
                                                 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1
                                                 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="line-through text-gray-400">{{ $item['label'] }}</span>
                                @else
                                    <svg class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 flex-shrink-0"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0
                                                 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3
                                                 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11
                                                 10.586V7z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $item['label'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </form>
@push('scripts')
<script>
    document.getElementById('avatar-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('avatar-preview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush

@endsection
