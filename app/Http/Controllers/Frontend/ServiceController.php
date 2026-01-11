<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display the services page.
     */
    public function index(): View
    {
        // Get services page content
        $page = Page::with(['headerImage', 'translations'])
            ->where('slug', 'services')
            ->where('status', 'published')
            ->first();

        $services = Service::with(['featuredImage', 'translations'])
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.services.index', compact('services', 'page'));
    }

    /**
     * Display a single service.
     */
    public function show(): View
    {
        $slug = request()->route('slug');
        $service = Service::with(['featuredImage', 'translations', 'sections.translations'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related services (same or similar, excluding current)
        $relatedServices = Service::with(['featuredImage', 'translations'])
            ->where('is_active', true)
            ->where('id', '!=', $service->id)
            ->orderBy('order', 'asc')
            ->limit(3)
            ->get();

        return view('frontend.services.show', compact('service', 'relatedServices'));
    }
}
