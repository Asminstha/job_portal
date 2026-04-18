@extends('layouts.admin')

@section('title', isset($category->id) ? 'Edit Category' : 'Add Category')
@section('page-title', isset($category->id) ? 'Edit: ' . $category->name : 'Add New Category')
@section('page-subtitle', isset($category->id) ? 'Update this category' : 'Create a new job category')

@section('content')

<div class=" w-full">
    <form method="POST"
          action="{{ isset($category->id)
              ? route('admin.categories.update', $category->id)
              : route('admin.categories.store') }}">
        @csrf
        @if(isset($category->id)) @method('PUT') @endif

        <div class="card p-6 space-y-5">

            {{-- Name --}}
            <div>
                <label class="form-label">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name"
                       value="{{ old('name', $category->name ?? '') }}"
                       class="form-input @error('name') border-red-500 @enderror"
                       placeholder="e.g. Information Technology"
                       autofocus>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Slug (only for create) --}}
            @if(!isset($category->id))
            <div>
                <label class="form-label">
                    Slug
                    <span class="text-gray-400 font-normal text-xs ml-1">
                        (auto-generated if left blank)
                    </span>
                </label>
                <input type="text" name="slug"
                       value="{{ old('slug') }}"
                       class="form-input @error('slug') border-red-500 @enderror"
                       placeholder="information-technology">
                <p class="text-xs text-gray-400 mt-1">
                    Used in URLs. Only lowercase letters, numbers, and hyphens.
                </p>
                @error('slug')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            @else
            <div>
                <label class="form-label">Slug (cannot be changed)</label>
                <input type="text" value="{{ $category->slug }}"
                       class="form-input bg-gray-100 dark:bg-gray-800 cursor-not-allowed"
                       readonly disabled>
            </div>
            @endif

            {{-- Icon --}}
            <div>
                <label class="form-label">
                    Icon (Emoji) <span class="text-red-500">*</span>
                </label>
                <div x-data="{ icon: '{{ old('icon', $category->icon ?? '🔖') }}' }"
                     class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gray-100 dark:bg-gray-800 rounded-xl
                                flex items-center justify-center flex-shrink-0">
                        <span class="text-3xl" x-text="icon"></span>
                    </div>
                    <div class="flex-1">
                        <input type="text" name="icon"
                               x-model="icon"
                               class="form-input text-center text-xl"
                               placeholder="💻"
                               maxlength="4">
                        <p class="text-xs text-gray-400 mt-1.5">
                            Copy any emoji and paste here:
                            💻 🎨 📢 💰 👥 🎧 ⚙️ 🏥 📚 ⚖️ 📋 🔖 🚀 📊 🏗️ 🌐 ✈️ 🍕
                        </p>
                    </div>
                </div>
            </div>

            {{-- Sort Order --}}
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" min="0"
                       value="{{ old('sort_order', $category->sort_order ?? 99) }}"
                       class="form-input w-32">
                <p class="text-xs text-gray-400 mt-1">
                    Lower number = shown first on homepage.
                    Current categories use 1–12.
                </p>
            </div>

            {{-- Active toggle --}}
            <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300
                                  text-brand-600 focus:ring-brand-500">
                    <div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Active
                        </span>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Inactive categories are hidden from employers and the homepage
                        </p>
                    </div>
                </label>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary px-8">
                    {{ isset($category->id) ? 'Update Category' : 'Create Category' }}
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="btn-secondary px-6">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>

@endsection
