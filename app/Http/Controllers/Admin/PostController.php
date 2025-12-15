<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['author', 'category', 'featuredImage'])
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
            'filters' => $request->only(['search', 'status', 'category']),
            'categories' => Category::where('is_active', true)->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Posts/Form', [
            'post' => null,
            'categories' => Category::where('is_active', true)->get(),
            'locales' => available_locales(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:posts,slug',
            'category_id' => 'nullable|exists:categories,id',
            'featured_image_id' => 'nullable|exists:media,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.excerpt' => 'nullable|string',
            'translations.*.content' => 'required|string',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string',
        ]);

        $post = Post::create([
            'slug' => $validated['slug'],
            'title' => $validated['translations']['en']['title'] ?? '',
            'excerpt' => $validated['translations']['en']['excerpt'] ?? '',
            'content' => $validated['translations']['en']['content'] ?? '',
            'category_id' => $validated['category_id'] ?? null,
            'author_id' => auth()->id(),
            'featured_image_id' => $validated['featured_image_id'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
            'meta_title' => $validated['translations']['en']['meta_title'] ?? '',
            'meta_description' => $validated['translations']['en']['meta_description'] ?? '',
        ]);

        // Save translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $post->setTranslation($field, $locale, $value);
                }
            }
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully');
    }

    public function edit(Post $post)
    {
        $post->load(['category', 'featuredImage']);

        // Get all translations
        $translations = [];
        $enabledLocales = array_keys(available_locales());

        foreach ($enabledLocales as $locale) {
            foreach ($post->translatable as $field) {
                $translations[$locale][$field] = $post->translate($field, $locale);
            }
        }

        return Inertia::render('Admin/Posts/Form', [
            'post' => $post,
            'translations' => $translations,
            'categories' => Category::where('is_active', true)->get(),
            'locales' => available_locales(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:posts,slug,' . $post->id,
            'category_id' => 'nullable|exists:categories,id',
            'featured_image_id' => 'nullable|exists:media,id',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.excerpt' => 'nullable|string',
            'translations.*.content' => 'required|string',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string',
        ]);

        $post->update([
            'slug' => $validated['slug'],
            'title' => $validated['translations']['en']['title'] ?? '',
            'excerpt' => $validated['translations']['en']['excerpt'] ?? '',
            'content' => $validated['translations']['en']['content'] ?? '',
            'category_id' => $validated['category_id'] ?? null,
            'featured_image_id' => $validated['featured_image_id'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
            'meta_title' => $validated['translations']['en']['meta_title'] ?? '',
            'meta_description' => $validated['translations']['en']['meta_description'] ?? '',
        ]);

        // Update translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $post->setTranslation($field, $locale, $value ?? '');
            }
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully');
    }
}
