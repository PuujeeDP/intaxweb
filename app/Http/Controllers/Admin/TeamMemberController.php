<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = TeamMember::with(['photo'])
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('slug', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $teamMembers = $query->paginate(15)->withQueryString();

        return Inertia::render('Admin/TeamMembers/Index', [
            'teamMembers' => $teamMembers,
            'filters' => $request->only(['search', 'is_active']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/TeamMembers/Form', [
            'teamMember' => null,
            'locales' => available_locales(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:team_members,slug',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'photo_id' => 'nullable|exists:media,id',
            'is_active' => 'required|boolean',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.position' => 'required|string|max:255',
            'translations.*.bio' => 'nullable|string',
        ]);

        $teamMember = TeamMember::create([
            'slug' => $validated['slug'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'twitter' => $validated['twitter'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'photo_id' => $validated['photo_id'] ?? null,
            'is_active' => $validated['is_active'],
            'order' => $validated['order'] ?? 0,
        ]);

        // Save translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $teamMember->setTranslation($field, $locale, $value);
                }
            }
        }

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member created successfully');
    }

    public function edit(TeamMember $team)
    {
        $team->load(['photo']);

        // Get all translations
        $translations = [];
        $locales = array_keys(available_locales());
        $translatableFields = $team->translatable ?? ['name', 'position', 'bio'];

        foreach ($locales as $locale) {
            foreach ($translatableFields as $field) {
                $translations[$locale][$field] = $team->translate($field, $locale);
            }
        }

        return Inertia::render('Admin/TeamMembers/Form', [
            'teamMember' => $team,
            'translations' => $translations,
            'locales' => available_locales(),
        ]);
    }

    public function update(Request $request, TeamMember $team)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:team_members,slug,' . $team->id,
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'photo_id' => 'nullable|exists:media,id',
            'is_active' => 'required|boolean',
            'order' => 'nullable|integer',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.position' => 'required|string|max:255',
            'translations.*.bio' => 'nullable|string',
        ]);

        $team->update([
            'slug' => $validated['slug'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'facebook' => $validated['facebook'] ?? null,
            'twitter' => $validated['twitter'] ?? null,
            'linkedin' => $validated['linkedin'] ?? null,
            'photo_id' => $validated['photo_id'] ?? null,
            'is_active' => $validated['is_active'],
            'order' => $validated['order'] ?? 0,
        ]);

        // Update translations
        foreach ($validated['translations'] as $locale => $fields) {
            foreach ($fields as $field => $value) {
                if ($value) {
                    $team->setTranslation($field, $locale, $value);
                }
            }
        }

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member updated successfully');
    }

    public function destroy(TeamMember $team)
    {
        $team->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member deleted successfully');
    }
}
