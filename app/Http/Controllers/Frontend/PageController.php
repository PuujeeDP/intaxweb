<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the specified page
     */
    Public function show(): View
    {
        $slug = request()->route('slug');
        $page = Page::with(['author', 'headerImage', 'sections' => function($query) {
                $query->where('is_active', true)->orderBy('order', 'asc');
            }])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.pages.show', compact('page'));
    }
}
