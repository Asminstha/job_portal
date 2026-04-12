@extends('layouts.app')
@section('title', 'Company Profile')
@section('page-title', 'Company Profile')
@section('page-subtitle', 'Update your public company information')

@section('content')

<div class="max-w-3xl">
    <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Logo --}}
        <div class="card p-6 mb-5">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Company Logo</h2>
            <div class="flex items-center gap-5">
                <img src="{{ $company->logoUrl() }}" alt="{{ $company->name }}"
                     class="w-20 h-20 rounded-xl object-cover border border-gray-200 dark:border-gray-700">
                <div>
                    <input type="file" name="logo" accept="image/*"
                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                  file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-brand-50 file:text-brand-700
                                  dark:file:bg-brand-900 dark:file:text-brand-300
                                  hover:file:bg-brand-100 transition-colors cursor-pointer">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">
                        PNG, JPG, GIF — max 2MB. Square image recommended.
                    </p>
                    @error('logo') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Basic Info --}}
        <div class="card p-6 mb-5">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-5">Basic Information</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="form-label">Company Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $company->name) }}"
                           class="form-input @error('name') border-red-500 @enderror">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label">Industry</label>
                    <select name="industry" class="form-input">
                        <option value="">Select industry</option>
                        @foreach(['Information Technology','Software Development','BPO / KPO','Banking & Finance','Healthcare','Education & Training','Media & Communications','E-Commerce','Manufacturing','Hospitality','Others'] as $ind)
                            <option value="{{ $ind }}" {{ old('industry', $company->industry) === $ind ? 'selected' : '' }}>
                                {{ $ind }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Company Size</label>
                    <select name="size" class="form-input">
                        <option value="">Select size</option>
                        @foreach(['1-10','11-50','51-200','201-500','500+'] as $size)
                            <option value="{{ $size }}" {{ old('size', $company->size) === $size ? 'selected' : '' }}>
                                {{ $size }} employees
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $company->phone) }}"
                           class="form-input" placeholder="+977 01-XXXXXXX">
                </div>
                <div>
                    <label class="form-label">Website</label>
                    <input type="url" name="website" value="{{ old('website', $company->website) }}"
                           class="form-input" placeholder="https://yourcompany.com">
                    @error('website') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Company Description</label>
                    <textarea name="description" rows="4" class="form-input resize-y"
                              placeholder="Tell job seekers about your company, culture, and mission...">{{ old('description', $company->description) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Max 2000 characters</p>
                </div>
            </div>
        </div>

        {{-- Location --}}
        <div class="card p-6 mb-5">
            <h2 class="font-semibold text-gray-900 dark:text-white mb-5">Location</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-3">
                    <label class="form-label">Street Address</label>
                    <input type="text" name="address" value="{{ old('address', $company->address) }}"
                           class="form-input" placeholder="Baneshwor, Kathmandu">
                </div>
                <div>
                    <label class="form-label">City</label>
                    <input type="text" name="city" value="{{ old('city', $company->city) }}"
                           class="form-input" placeholder="Kathmandu">
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" value="{{ old('country', $company->country ?? 'Nepal') }}"
                           class="form-input">
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary px-8">Save Changes</button>
            <a href="{{ route('company.dashboard') }}" class="btn-secondary px-6">Cancel</a>
        </div>
    </form>
</div>

@endsection
