<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $query = Slider::with(['image'])
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('button_text', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $sliders = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/Sliders/Index', [
            'sliders' => $sliders,
            'filters' => $request->only(['search', 'is_active']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Sliders/Form', [
            'slider' => null,
            'locales' => available_locales(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_id' => 'nullable|exists:media,id',
            'button_target' => 'required|in:_self,_blank',
            'is_active' => 'required|boolean',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.subtitle' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.button_text' => 'nullable|string|max:255',
            'translations.*.button_url' => 'nullable|string|max:500',
        ]);

        $slider = Slider::create([
            'image_id' => $validated['image_id'] ?? null,
            'button_target' => $validated['button_target'],
            'is_active' => $validated['is_active'],
            'order' => $validated['order'] ?? 0,
        ]);

        // Save translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $slider->setTranslation($field, $locale, $value);
                }
            }
        }

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created successfully');
    }

    public function edit(Slider $slider)
    {
        $slider->load(['image']);

        // Get all translations
        $translations = [];
        $locales = array_keys(available_locales());
        $translatableFields = $slider->translatable ?? ['title', 'subtitle', 'description', 'button_text', 'button_url'];

        foreach ($locales as $locale) {
            foreach ($translatableFields as $field) {
                $translations[$locale][$field] = $slider->translate($field, $locale);
            }
        }

        return Inertia::render('Admin/Sliders/Form', [
            'slider' => $slider,
            'translations' => $translations,
            'locales' => available_locales(),
        ]);
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'image_id' => 'nullable|exists:media,id',
            'button_target' => 'required|in:_self,_blank',
            'is_active' => 'required|boolean',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.subtitle' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.button_text' => 'nullable|string|max:255',
            'translations.*.button_url' => 'nullable|string|max:500',
        ]);

        $slider->update([
            'image_id' => $validated['image_id'] ?? null,
            'button_target' => $validated['button_target'],
            'is_active' => $validated['is_active'],
            'order' => $validated['order'] ?? 0,
        ]);

        // Update translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $slider->setTranslation($field, $locale, $value);
                }
            }
        }

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully');
    }
}
