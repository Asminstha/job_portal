<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = JobCategory::withCount([
                'jobs' => fn($q) => $q->withoutGlobalScopes()
            ])
            ->orderBy('sort_order')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

   public function create(): View
{
        $categories = JobCategory::all(); // fetch data
        $categoriesCount = $categories->count(); // count the number of categories
    return view('admin.categories.form', compact('categories', 'categoriesCount'));
}


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'slug'       => ['nullable', 'string', 'unique:job_categories,slug'],
            'icon'       => ['nullable', 'string', 'max:10'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable'],
        ]);

        JobCategory::create([
            'name'       => $request->name,
            'slug'       => $request->slug ?? Str::slug($request->name),
            'icon'       => $request->icon ?? '🔖',
            'sort_order' => $request->sort_order ?? 99,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(string $id): View
{
    $category = JobCategory::findOrFail($id);
    $categoriesCount = JobCategory::count();
    return view('admin.categories.form', compact('category', 'categoriesCount'));
}


   public function update(Request $request, string $id): RedirectResponse
{
    $category = JobCategory::findOrFail($id);

    $request->validate([
        'name'       => ['required', 'string', 'max:100'],
        'icon'       => ['nullable', 'string', 'max:10'],
        'sort_order' => ['nullable', 'integer', 'min:0'],
        'is_active'  => ['nullable'],
    ]);

    $category->update([
        'name'       => $request->name,
        'icon'       => $request->icon ?? $category->icon,
        'sort_order' => $request->sort_order ?? $category->sort_order,
        'is_active'  => $request->boolean('is_active'),
    ]);

    return redirect()->route('admin.categories.index')
        ->with('success', 'Category updated.');
}

    public function destroy(string $id): RedirectResponse
{
    $category = JobCategory::findOrFail($id);

    if ($category->jobs()->withoutGlobalScopes()->count() > 0) {
        return back()->with('error',
            'Cannot delete — this category has ' .
            $category->jobs()->withoutGlobalScopes()->count() .
            ' jobs. Deactivate it instead.');
    }

    $category->delete();
    return back()->with('success', 'Category deleted.');
}
}
