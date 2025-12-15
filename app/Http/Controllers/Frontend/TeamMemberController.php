<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    /**
     * Display the team members page.
     */
    public function index(): View
    {
        $teamMembers = TeamMember::with(['photo', 'translations'])
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.team.index', compact('teamMembers'));
    }
}
