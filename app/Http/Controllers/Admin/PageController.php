<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with(['author'])
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $pages = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/Pages/Index', [
            'pages' => $pages,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Pages/Form', [
            'page' => null,
            'sections' => [],
            'locales' => available_locales(),
        ]);
    }

    public function store(Request $request)
    {
        // Debug logging
        \Log::info('Page store request - all data:', $request->all());
        \Log::info('Page store request - sections data:', $request->input('sections'));

        $validated = $request->validate([
            'slug' => 'required|string|unique:pages,slug',
            'template' => 'required|string',
            'header_image_id' => 'nullable|exists:media,id',
            'hide_title' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.content' => 'required|string',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string',
            'sections' => 'nullable|array',
            'sections.*.type' => 'required|in:tab,accordion',
            'sections.*.icon' => 'nullable|string',
            'sections.*.order' => 'nullable|integer',
            'sections.*.is_active' => 'nullable|boolean',
            'sections.*.translations' => 'required|array',
            'sections.*.translations.*.title' => 'required|string',
            'sections.*.translations.*.content' => 'required|string',
        ]);

        $page = Page::create([
            'slug' => $validated['slug'],
            'title' => $validated['translations']['en']['title'] ?? '',
            'content' => $validated['translations']['en']['content'] ?? '',
            'template' => $validated['template'],
            'header_image_id' => $validated['header_image_id'] ?? null,
            'hide_title' => $validated['hide_title'] ?? false,
            'author_id' => auth()->id(),
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
            'meta_title' => $validated['translations']['en']['meta_title'] ?? '',
            'meta_description' => $validated['translations']['en']['meta_description'] ?? '',
            'order' => $validated['order'] ?? 0,
        ]);

        // Save translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $page->setTranslation($field, $locale, $value);
                }
            }
        }

        // Save sections
        if (isset($validated['sections'])) {
            foreach ($validated['sections'] as $sectionData) {
                $section = $page->sections()->create([
                    'type' => $sectionData['type'],
                    'icon' => $sectionData['icon'] ?? null,
                    'order' => $sectionData['order'] ?? 0,
                    'is_active' => $sectionData['is_active'] ?? true,
                ]);

                foreach ($sectionData['translations'] as $locale => $fields) {
                    $section->setTranslation('title', $locale, $fields['title']);
                    $section->setTranslation('content', $locale, $fields['content']);
                }
            }
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully');
    }

    public function edit(Page $page)
    {
        $page->load(['sections', 'headerImage']);

        // Get all translations
        $translations = [];
        $locales = array_keys(available_locales());

        foreach ($locales as $locale) {
            foreach ($page->translatable as $field) {
                $translations[$locale][$field] = $page->translate($field, $locale);
            }
        }

        // Prepare sections data
        $sectionsData = $page->sections->map(function ($section) {
            $translations = [];
            foreach (['en', 'mn', 'zh'] as $locale) {
                $translations[$locale] = [
                    'title' => $section->translate('title', $locale),
                    'content' => $section->translate('content', $locale),
                ];
            }
            return [
                'id' => $section->id,
                'type' => $section->type,
                'icon' => $section->icon,
                'order' => $section->order,
                'is_active' => $section->is_active,
                'translations' => $translations,
            ];
        });

        return Inertia::render('Admin/Pages/Form', [
            'page' => $page,
            'sections' => $sectionsData,
            'translations' => $translations,
            'locales' => available_locales(),
            'headerImage' => $page->headerImage,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:pages,slug,' . $page->id,
            'template' => 'required|string',
            'header_image_id' => 'nullable|exists:media,id',
            'hide_title' => 'nullable|boolean',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.content' => 'required|string',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string',
            'sections' => 'nullable|array',
            'sections.*.type' => 'required|in:tab,accordion',
            'sections.*.icon' => 'nullable|string',
            'sections.*.order' => 'nullable|integer',
            'sections.*.is_active' => 'nullable|boolean',
            'sections.*.translations' => 'required|array',
            'sections.*.translations.*.title' => 'required|string',
            'sections.*.translations.*.content' => 'required|string',
        ]);

        $page->update([
            'slug' => $validated['slug'],
            'title' => $validated['translations']['en']['title'] ?? '',
            'content' => $validated['translations']['en']['content'] ?? '',
            'template' => $validated['template'],
            'header_image_id' => $validated['header_image_id'] ?? null,
            'hide_title' => $validated['hide_title'] ?? false,
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
            'meta_title' => $validated['translations']['en']['meta_title'] ?? '',
            'meta_description' => $validated['translations']['en']['meta_description'] ?? '',
            'order' => $validated['order'] ?? 0,
        ]);

        // Update translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $page->setTranslation($field, $locale, $value ?? '');
            }
        }

        // Update sections - delete all and recreate
        $page->sections()->delete();
        if (isset($validated['sections'])) {
            foreach ($validated['sections'] as $sectionData) {
                $section = $page->sections()->create([
                    'type' => $sectionData['type'],
                    'icon' => $sectionData['icon'] ?? null,
                    'order' => $sectionData['order'] ?? 0,
                    'is_active' => $sectionData['is_active'] ?? true,
                ]);

                foreach ($sectionData['translations'] as $locale => $fields) {
                    $section->setTranslation('title', $locale, $fields['title']);
                    $section->setTranslation('content', $locale, $fields['content']);
                }
            }
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully');
    }
}
