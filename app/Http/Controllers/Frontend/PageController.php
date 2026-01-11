<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\TeamMember;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the specified page
     */
    public function show(): View
    {
        $slug = request()->route('slug');
        $page = Page::with(['author', 'headerImage', 'sections' => function($query) {
                $query->where('is_active', true)->orderBy('order', 'asc');
            }])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Load team members only for about page
        $teamMembers = collect();
        if ($slug === 'about') {
            $teamMembers = TeamMember::with('photo')
                ->where('is_active', true)
                ->orderBy('order', 'asc')
                ->get();
        }

        return view('frontend.pages.show', compact('page', 'teamMembers'));
    }
}
