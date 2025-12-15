<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of posts
     */
    public function index(Request $request): View
    {
      
        $query = Post::with(['author', 'category', 'featuredImage'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('excerpt', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        $posts = $query->paginate(12);

        // Get all active categories with post counts
        $categories = Category::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published')
                    ->where('published_at', '<=', now());
            }])
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('frontend.posts.index', [
            'posts' => $posts,
            'search' => $request->search,
            'categories' => $categories,
        ]);
    }

    /**
     * Display the specified post
     */
    public function show(): View
    {
        // Get slug from route parameter directly to avoid Laravel's parameter injection confusion
        // with multiple route parameters (locale and slug)
        $slug = request()->route('slug');

        $post = Post::with(['author', 'category', 'featuredImage'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Get related posts from same category
        $relatedPosts = Post::with(['author', 'category', 'featuredImage'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('frontend.posts.show', compact('post', 'relatedPosts'));
    }
}
