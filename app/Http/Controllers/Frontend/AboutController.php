<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\TeamMember;

class AboutController extends Controller
{
    /**
     * Display the about page.
     */
    public function index(): View
    {
        $teamMembers = TeamMember::with(['photo', 'translations'])
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.about.index', compact('teamMembers'));
    }
}
