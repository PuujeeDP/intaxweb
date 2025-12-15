<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompanyHistory;

class CompanyHistoryController extends Controller
{
    public function index()
    {
        $histories = CompanyHistory::with('image')
            ->active()
            ->ordered()
            ->paginate(10);

        return view('frontend.history.index', [
            'histories' => $histories,
        ]);
    }
}
