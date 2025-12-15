<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyHistory;
use App\Models\Media;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyHistoryController extends Controller
{
    public function index()
    {
        $histories = CompanyHistory::with('image')
            ->ordered()
            ->paginate(20);

        return Inertia::render('Admin/CompanyHistories/Index', [
            'histories' => $histories,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/CompanyHistories/Create', [
            'locales' => available_locales(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|unique:company_histories,year',
            'title_en' => 'required|string|max:255',
            'title_mn' => 'required|string|max:255',
            'title_zh' => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_mn' => 'required|string',
            'description_zh' => 'nullable|string',
            'image_id' => 'nullable|exists:media,id',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $history = CompanyHistory::create([
            'year' => $validated['year'],
            'image_id' => $validated['image_id'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'order' => $validated['order'] ?? 0,
        ]);

        // Set translations
        $history->setTranslation('title', 'en', $validated['title_en']);
        $history->setTranslation('title', 'mn', $validated['title_mn']);
        $history->setTranslation('title', 'zh', $validated['title_zh'] ?? '');

        $history->setTranslation('description', 'en', $validated['description_en']);
        $history->setTranslation('description', 'mn', $validated['description_mn']);
        $history->setTranslation('description', 'zh', $validated['description_zh'] ?? '');

        $history->save();

        return redirect()->route('admin.company-histories.index')
            ->with('success', 'Company history created successfully.');
    }

    public function edit(CompanyHistory $companyHistory)
    {
        $companyHistory->load('image');

        // Get translations
        $companyHistory->title_en = $companyHistory->translate('title', 'en');
        $companyHistory->title_mn = $companyHistory->translate('title', 'mn');
        $companyHistory->title_zh = $companyHistory->translate('title', 'zh');

        $companyHistory->description_en = $companyHistory->translate('description', 'en');
        $companyHistory->description_mn = $companyHistory->translate('description', 'mn');
        $companyHistory->description_zh = $companyHistory->translate('description', 'zh');

        return Inertia::render('Admin/CompanyHistories/Edit', [
            'history' => $companyHistory,
            'locales' => available_locales(),
        ]);
    }

    public function update(Request $request, CompanyHistory $companyHistory)
    {
        $validated = $request->validate([
            'year' => 'required|integer|unique:company_histories,year,' . $companyHistory->id,
            'title_en' => 'required|string|max:255',
            'title_mn' => 'required|string|max:255',
            'title_zh' => 'nullable|string|max:255',
            'description_en' => 'required|string',
            'description_mn' => 'required|string',
            'description_zh' => 'nullable|string',
            'image_id' => 'nullable|exists:media,id',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $companyHistory->update([
            'year' => $validated['year'],
            'image_id' => $validated['image_id'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'order' => $validated['order'] ?? 0,
        ]);

        // Update translations
        $companyHistory->setTranslation('title', 'en', $validated['title_en']);
        $companyHistory->setTranslation('title', 'mn', $validated['title_mn']);
        $companyHistory->setTranslation('title', 'zh', $validated['title_zh'] ?? '');

        $companyHistory->setTranslation('description', 'en', $validated['description_en']);
        $companyHistory->setTranslation('description', 'mn', $validated['description_mn']);
        $companyHistory->setTranslation('description', 'zh', $validated['description_zh'] ?? '');

        $companyHistory->save();

        return redirect()->route('admin.company-histories.index')
            ->with('success', 'Company history updated successfully.');
    }

    public function destroy(CompanyHistory $companyHistory)
    {
        $companyHistory->delete();

        return redirect()->route('admin.company-histories.index')
            ->with('success', 'Company history deleted successfully.');
    }
}
