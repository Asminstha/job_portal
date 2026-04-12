<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Left: Main fields --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Basic Info --}}
        <div class="card p-6">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-5">Job Details</h2>

            <div class="space-y-4">
                <div>
                    <label class="form-label">Job Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $job->title ?? '') }}"
                           class="form-input @error('title') border-red-500 @enderror"
                           placeholder="e.g. Senior Laravel Developer">
                    @error('title') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-input">
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $job->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->icon }} {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Job Type <span class="text-red-500">*</span></label>
                        <select name="type" class="form-input @error('type') border-red-500 @enderror">
                            @foreach(['full_time' => 'Full Time','part_time' => 'Part Time','contract' => 'Contract','internship' => 'Internship','freelance' => 'Freelance'] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('type', $job->type ?? 'full_time') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label">Job Description <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="8"
                              class="form-input resize-y @error('description') border-red-500 @enderror"
                              placeholder="Describe the role, responsibilities, and what a typical day looks like...">{{ old('description', $job->description ?? '') }}</textarea>
                    @error('description') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Requirements</label>
                    <textarea name="requirements" rows="5"
                              class="form-input resize-y"
                              placeholder="List required skills, qualifications, and experience. Use new lines for each point.">{{ old('requirements', $job->requirements ?? '') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Benefits & Perks</label>
                    <textarea name="benefits" rows="4"
                              class="form-input resize-y"
                              placeholder="Health insurance, flexible hours, remote options, bonus...">{{ old('benefits', $job->benefits ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Location --}}
        <div class="card p-6">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-5">Location</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">Work Mode <span class="text-red-500">*</span></label>
                    <select name="location_type" class="form-input">
                        <option value="onsite"  {{ old('location_type', $job->location_type ?? 'onsite') === 'onsite'  ? 'selected' : '' }}>On-site</option>
                        <option value="remote"  {{ old('location_type', $job->location_type ?? '') === 'remote'  ? 'selected' : '' }}>Remote</option>
                        <option value="hybrid"  {{ old('location_type', $job->location_type ?? '') === 'hybrid'  ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">City</label>
                    <input type="text" name="city" value="{{ old('city', $job->city ?? '') }}"
                           class="form-input" placeholder="Kathmandu">
                </div>
                <div>
                    <label class="form-label">Country</label>
                    <input type="text" name="country" value="{{ old('country', $job->country ?? 'Nepal') }}"
                           class="form-input" placeholder="Nepal">
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Salary, experience, settings --}}
    <div class="space-y-5">

        {{-- Salary --}}
        <div class="card p-6">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Salary</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Min</label>
                        <input type="number" name="salary_min"
                               value="{{ old('salary_min', $job->salary_min ?? '') }}"
                               class="form-input" placeholder="50000">
                    </div>
                    <div>
                        <label class="form-label">Max</label>
                        <input type="number" name="salary_max"
                               value="{{ old('salary_max', $job->salary_max ?? '') }}"
                               class="form-input" placeholder="100000">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Currency</label>
                        <select name="salary_currency" class="form-input">
                            <option value="NPR" {{ old('salary_currency', $job->salary_currency ?? 'NPR') === 'NPR' ? 'selected' : '' }}>NPR</option>
                            <option value="USD" {{ old('salary_currency', $job->salary_currency ?? '') === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="INR" {{ old('salary_currency', $job->salary_currency ?? '') === 'INR' ? 'selected' : '' }}>INR</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Period</label>
                        <select name="salary_period" class="form-input">
                            <option value="monthly" {{ old('salary_period', $job->salary_period ?? 'monthly') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly"  {{ old('salary_period', $job->salary_period ?? '') === 'yearly'  ? 'selected' : '' }}>Yearly</option>
                            <option value="hourly"  {{ old('salary_period', $job->salary_period ?? '') === 'hourly'  ? 'selected' : '' }}>Hourly</option>
                        </select>
                    </div>
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="salary_hidden" value="1"
                           {{ old('salary_hidden', $job->salary_hidden ?? false) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-brand-600">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Hide salary (show "Negotiable")</span>
                </label>
            </div>
        </div>

        {{-- Experience --}}
        <div class="card p-6">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Experience</h2>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="form-label">Min (years)</label>
                    <input type="number" name="experience_min" min="0"
                           value="{{ old('experience_min', $job->experience_min ?? 0) }}"
                           class="form-input">
                </div>
                <div>
                    <label class="form-label">Max (years)</label>
                    <input type="number" name="experience_max" min="0"
                           value="{{ old('experience_max', $job->experience_max ?? '') }}"
                           class="form-input" placeholder="Optional">
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="card p-6">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Settings</h2>
            <div class="space-y-4">
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="draft"  {{ old('status', $job->status ?? 'draft') === 'draft'  ? 'selected' : '' }}>Draft (not visible)</option>
                        <option value="active" {{ old('status', $job->status ?? '') === 'active' ? 'selected' : '' }}>Active (visible to all)</option>
                        @if(isset($job))
                        <option value="paused" {{ old('status', $job->status) === 'paused' ? 'selected' : '' }}>Paused</option>
                        <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="expires_at"
                           value="{{ old('expires_at', isset($job) && $job->expires_at ? $job->expires_at->format('Y-m-d') : '') }}"
                           class="form-input"
                           min="{{ now()->addDay()->format('Y-m-d') }}">
                    <p class="text-xs text-gray-400 mt-1">Leave empty for no deadline</p>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
            {{ isset($job) ? 'Update Job' : 'Post Job' }}
        </button>
        <a href="{{ route('company.jobs.index') }}"
           class="btn-secondary w-full justify-center py-2.5">
            Cancel
        </a>
    </div>
</div>
