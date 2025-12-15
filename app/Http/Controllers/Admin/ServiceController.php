<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['featuredImage'])
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('slug', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $services = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/Services/Index', [
            'services' => $services,
            'filters' => $request->only(['search', 'is_active']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Services/Form', [
            'service' => null,
            'sections' => [],
            'translations' => null,
            'locales' => available_locales(),
            'widgets' => \App\Models\Widget::where('is_active', true)->orderBy('order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services,slug',
            'icon' => 'nullable|string',
            'featured_image_id' => 'nullable|exists:media,id',
            'is_active' => 'required|boolean',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.content' => 'nullable|string',
            'sections' => 'nullable|array',
            'sections.*.type' => 'required|in:tab,accordion,content',
            'sections.*.icon' => 'nullable|string',
            'sections.*.order' => 'nullable|integer',
            'sections.*.is_active' => 'nullable|boolean',
            'sections.*.translations' => 'required|array',
            'sections.*.translations.*.title' => 'required|string',
            'sections.*.translations.*.content' => 'required|string',
            'widgets' => 'nullable|array',
        ]);

        $service = Service::create([
            'slug' => $validated['slug'],
            'icon' => $validated['icon'] ?? null,
            'featured_image_id' => $validated['featured_image_id'] ?? null,
            'is_active' => $validated['is_active'],
            'order' => $validated['order'] ?? 0,
        ]);

        // Save translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $service->setTranslation($field, $locale, $value);
                }
            }
        }

        // Save sections
        if (!empty($validated['sections'])) {
            foreach ($validated['sections'] as $sectionData) {
                $section = $service->sections()->create([
                    'title' => $sectionData['translations']['en']['title'] ?? '',
                    'content' => $sectionData['translations']['en']['content'] ?? '',
                    'type' => $sectionData['type'],
                    'icon' => $sectionData['icon'] ?? null,
                    'order' => $sectionData['order'] ?? 0,
                    'is_active' => $sectionData['is_active'] ?? true,
                ]);

                foreach ($sectionData['translations'] as $locale => $fields) {
                    foreach ($fields as $field => $value) {
                        if ($value) {
                            $section->setTranslation($field, $locale, $value);
                        }
                    }
                }
            }
        }

        // Save widgets
        if (!empty($validated['widgets'])) {
            foreach ($validated['widgets'] as $index => $widgetId) {
                $service->widgets()->attach($widgetId, ['order' => $index]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        $service->load(['featuredImage', 'sections', 'widgets']);

        // Get all translations
        $translations = [];
        $locales = array_keys(available_locales());
        $translatableFields = $service->translatable ?? ['title', 'description', 'content'];

        foreach ($locales as $locale) {
            foreach ($translatableFields as $field) {
                $translations[$locale][$field] = $service->translate($field, $locale);
            }
        }

        // Get sections with translations
        $sections = $service->sections->map(function ($section) use ($locales) {
            $sectionTranslations = [];
            foreach ($locales as $locale) {
                $sectionTranslations[$locale] = [
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
                'translations' => $sectionTranslations,
            ];
        });

        return Inertia::render('Admin/Services/Form', [
            'service' => $service,
            'sections' => $sections,
            'translations' => $translations,
            'locales' => available_locales(),
            'widgets' => \App\Models\Widget::where('is_active', true)->orderBy('order')->get(),
            'selectedWidgets' => $service->widgets->pluck('id')->toArray(),
            'featuredImage' => $service->featuredImage,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:services,slug,' . $service->id,
            'icon' => 'nullable|string',
            'featured_image_id' => 'nullable|exists:media,id',
            'is_active' => 'required|boolean',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.content' => 'nullable|string',
            'sections' => 'nullable|array',
            'sections.*.type' => 'required|in:tab,accordion,content',
            'sections.*.icon' => 'nullable|string',
            'sections.*.order' => 'nullable|integer',
            'sections.*.is_active' => 'nullable|boolean',
            'sections.*.translations' => 'required|array',
            'sections.*.translations.*.title' => 'required|string',
            'sections.*.translations.*.content' => 'required|string',
            'widgets' => 'nullable|array',
        ]);

        $service->update([
            'slug' => $validated['slug'],
            'icon' => $validated['icon'] ?? null,
            'featured_image_id' => $validated['featured_image_id'] ?? null,
            'is_active' => $validated['is_active'],
            'order' => $validated['order'] ?? 0,
        ]);

        // Update translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $service->setTranslation($field, $locale, $value);
                }
            }
        }

        // Update sections (delete old and create new)
        $service->sections()->delete();
        if (!empty($validated['sections'])) {
            foreach ($validated['sections'] as $sectionData) {
                $section = $service->sections()->create([
                    'title' => $sectionData['translations']['en']['title'] ?? '',
                    'content' => $sectionData['translations']['en']['content'] ?? '',
                    'type' => $sectionData['type'],
                    'icon' => $sectionData['icon'] ?? null,
                    'order' => $sectionData['order'] ?? 0,
                    'is_active' => $sectionData['is_active'] ?? true,
                ]);

                foreach ($sectionData['translations'] as $locale => $fields) {
                    foreach ($fields as $field => $value) {
                        if ($value) {
                            $section->setTranslation($field, $locale, $value);
                        }
                    }
                }
            }
        }

        // Update widgets
        $service->widgets()->detach();
        if (!empty($validated['widgets'])) {
            foreach ($validated['widgets'] as $index => $widgetId) {
                $service->widgets()->attach($widgetId, ['order' => $index]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }
}
