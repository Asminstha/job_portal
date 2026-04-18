@extends('layouts.admin')
@section('title', 'Job Categories')
@section('page-title', 'Job Categories')
@section('page-subtitle', 'Manage all job categories shown to employers')

@section('content')

<div class="flex justify-between items-center mb-6">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        {{ $categories->count() }} categories total
    </p>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"/>
        </svg>
        Add Category
    </a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800
                           bg-gray-50 dark:bg-gray-800/50">
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 uppercase tracking-wider hidden md:table-cell">Slug</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 uppercase tracking-wider hidden md:table-cell">Jobs</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 uppercase tracking-wider hidden lg:table-cell">Order</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold
                               text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($categories as $cat)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors
                           {{ !$cat->is_active ? 'opacity-50' : '' }}">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ $cat->icon }}</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $cat->name }}
                            </span>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <code class="text-xs text-gray-500 dark:text-gray-400
                                     bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">
                            {{ $cat->slug }}
                        </code>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <span class="font-medium text-gray-700 dark:text-gray-300">
                            {{ $cat->jobs_count }}
                        </span>
                    </td>
                    <td class="px-5 py-4 hidden lg:table-cell
                               text-gray-500 dark:text-gray-400">
                        {{ $cat->sort_order }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="{{ $cat->is_active ? 'badge-green' : 'badge-gray' }}">
                            {{ $cat->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}"
                               class="btn-secondary text-xs py-1 px-2.5">
                                Edit
                            </a>
                            @if($cat->jobs_count === 0)
                            <form method="POST"
                                  action="{{ route('admin.categories.destroy', $cat->id) }}"
                                  onsubmit="return confirm('Delete {{ $cat->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs px-2.5 py-1 rounded-lg border
                                               border-red-200 text-red-600 hover:bg-red-50
                                               dark:border-red-800 dark:text-red-400
                                               transition-colors">
                                    Delete
                                </button>
                            </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Has jobs</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center">
                        <p class="text-gray-400 mb-3">No categories yet.</p>
                        <a href="{{ route('admin.categories.create') }}"
                           class="btn-primary text-sm inline-flex">
                            Add First Category
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
