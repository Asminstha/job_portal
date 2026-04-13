@extends('layouts.admin')
@section('title', isset($plan->id) ? 'Edit Plan' : 'Create Plan')
@section('page-title', isset($plan->id) ? 'Edit Plan: ' . $plan->name : 'Create New Plan')

@section('content')

<div class="max-w-2xl">
    <form method="POST"
          action="{{ isset($plan->id) ? route('admin.plans.update', $plan) : route('admin.plans.store') }}">
        @csrf
        @if(isset($plan->id)) @method('PUT') @endif

        <div class="card p-6 space-y-5">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Plan Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $plan->name) }}"
                           class="form-input @error('name') border-red-500 @enderror"
                           placeholder="Professional">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Slug <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $plan->slug) }}"
                           class="form-input @error('slug') border-red-500 @enderror"
                           placeholder="professional"
                           {{ isset($plan->id) ? 'readonly' : '' }}>
                    @error('slug') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="2" class="form-input resize-none"
                          placeholder="Brief description of this plan">{{ old('description', $plan->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Monthly Price (NPR) <span class="text-red-500">*</span></label>
                    <input type="number" name="price_monthly" min="0"
                           value="{{ old('price_monthly', $plan->price_monthly ?? 0) }}"
                           class="form-input">
                    @error('price_monthly') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Yearly Price (NPR) <span class="text-red-500">*</span></label>
                    <input type="number" name="price_yearly" min="0"
                           value="{{ old('price_yearly', $plan->price_yearly ?? 0) }}"
                           class="form-input">
                    @error('price_yearly') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Max Jobs (blank = unlimited)</label>
                    <input type="number" name="max_jobs" min="1"
                           value="{{ old('max_jobs', $plan->max_jobs) }}"
                           class="form-input" placeholder="Leave blank for unlimited">
                </div>
                <div>
                    <label class="form-label">Max Recruiters <span class="text-red-500">*</span></label>
                    <input type="number" name="max_recruiters" min="1"
                           value="{{ old('max_recruiters', $plan->max_recruiters ?? 1) }}"
                           class="form-input">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                           value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
                           class="form-input">
                </div>
            </div>

            <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Features</p>
                @foreach([
                    ['name' => 'has_ats',               'label' => 'ATS Pipeline (application status tracking)'],
                    ['name' => 'has_analytics',          'label' => 'Analytics & Reports'],
                    ['name' => 'featured_jobs_allowed',  'label' => 'Featured Job Postings'],
                ] as $feature)
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="{{ $feature['name'] }}" value="1"
                           {{ old($feature['name'], $plan->{$feature['name']} ?? false) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-brand-600">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature['label'] }}</span>
                </label>
                @endforeach

                @if(isset($plan->id))
                <label class="flex items-center gap-3 cursor-pointer pt-2">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $plan->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-brand-600">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Plan is active (visible to companies)</span>
                </label>
                @endif
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary px-8">
                    {{ isset($plan->id) ? 'Update Plan' : 'Create Plan' }}
                </button>
                <a href="{{ route('admin.plans.index') }}" class="btn-secondary px-6">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection
