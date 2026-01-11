<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Client;
use App\Models\Testimonial;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index(): View
    {
        // Get active sliders
        $sliders = Slider::with(['image'])
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        // Get latest published posts (10 for home page)
        $latestPosts = Post::with(['author', 'category', 'featuredImage'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(10)
            ->get();

        // Get featured posts (first 3)
        $featuredPosts = Post::with(['author', 'category', 'featuredImage'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get popular categories (PostgreSQL compatible)
        $categories = Category::withCount(['posts' => function ($query) {
                $query->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ;
            }])
            ->get()
            ->filter(fn($cat) => $cat->posts_count > 0)
            ->sortByDesc('posts_count')
            ->take(6);

        // Get active clients with logos
        $clients = Client::with('logo')
            ->active()
            ->ordered()
            ->get();

        // Get all unique tags from clients
        $clientTags = Client::active()
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        // Get active testimonials with client photos
        $testimonials = Testimonial::with('clientPhoto')
            ->active()
            ->ordered()
            ->get();

        // Get active services
        $services = Service::with(['featuredImage', 'translations'])
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.home', compact('sliders', 'latestPosts', 'featuredPosts', 'categories', 'clients', 'clientTags', 'testimonials', 'services'));
    }
}
