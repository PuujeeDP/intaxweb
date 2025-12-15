<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with(['parent', 'children'])
            ->withCount('posts')
            ->orderBy('order', 'asc')
            ->orderBy('name', 'asc');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $categories = $query->get();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
            'filters' => $request->only(['search', 'is_active']),
        ]);
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('Admin/Categories/Form', [
            'category' => null,
            'parentCategories' => $parentCategories,
            'locales' => available_locales(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
        ]);

        $category = Category::create([
            'slug' => $validated['slug'],
            'name' => $validated['translations']['en']['name'] ?? '',
            'description' => $validated['translations']['en']['description'] ?? '',
            'parent_id' => $validated['parent_id'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'],
        ]);

        // Save translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $category->setTranslation($field, $locale, $value);
                }
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();

        // Get all translations
        $translations = [];
        $locales = array_keys(available_locales());

        foreach ($locales as $locale) {
            foreach ($category->translatable as $field) {
                $translations[$locale][$field] = $category->translate($field, $locale);
            }
        }

        return Inertia::render('Admin/Categories/Form', [
            'category' => $category,
            'translations' => $translations,
            'parentCategories' => $parentCategories,
            'locales' => available_locales(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'is_active' => 'required|boolean',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
        ]);

        $category->update([
            'slug' => $validated['slug'],
            'name' => $validated['translations']['en']['name'] ?? '',
            'description' => $validated['translations']['en']['description'] ?? '',
            'parent_id' => $validated['parent_id'] ?? null,
            'order' => $validated['order'] ?? 0,
            'is_active' => $validated['is_active'],
        ]);

        // Update translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $category->setTranslation($field, $locale, $value ?? '');
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete category with posts');
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Cannot delete category with subcategories');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
