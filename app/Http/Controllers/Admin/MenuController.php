<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    /**
     * Display a listing of menus.
     */
    public function index(): Response
    {
        $menus = Menu::withCount('items')->get();

        return Inertia::render('Admin/Menus/Index', [
            'menus' => $menus,
        ]);
    }

    /**
     * Show the form for creating a new menu.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Menus/Create');
    }

    /**
     * Store a newly created menu.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255|unique:menus,location',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu created successfully.');
    }

    /**
     * Display the specified menu for editing.
     */
    public function edit(Menu $menu): Response
    {
        // Load ALL menu items (flat) with their relationships
        $menu->load(['items' => function ($query) {
            $query->with([
                'translations',
                'linkable',
            ])
                ->orderBy('order');
        }]);

        // Get available content for linking
        $availableContent = [
            'pages' => Page::select('id', 'title', 'slug')->get()->map(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug,
                    'type' => 'page',
                ];
            }),
            'posts' => Post::select('id', 'title', 'slug')->get()->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'type' => 'post',
                ];
            }),
            'categories' => Category::select('id', 'name', 'slug')->get()->map(function ($category) {
                return [
                    'id' => $category->id,
                    'title' => $category->name,
                    'slug' => $category->slug,
                    'type' => 'category',
                ];
            }),
        ];

        return Inertia::render('Admin/Menus/Edit', [
            'menu' => $menu,
            'availableContent' => $availableContent,
        ]);
    }

    /**
     * Update the specified menu.
     */
    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255|unique:menus,location,'.$menu->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu updated successfully.');
    }

    /**
     * Remove the specified menu.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }

    /**
     * Save menu items (create, update, delete).
     */
    public function saveItems(Request $request, Menu $menu): RedirectResponse
    {
        // Validate without strict type checking for IDs (they can be integers or temp strings)
        $request->validate([
            'items' => 'required|array',
            'items.*.type' => 'required|in:page,post,category,custom,external',
            'items.*.linkable_id' => 'nullable|integer',
            'items.*.linkable_type' => 'nullable|string',
            'items.*.url' => 'nullable|string|max:500',
            'items.*.title' => 'required|array',
            'items.*.title.en' => 'required|string|max:255',
            'items.*.title.mn' => 'nullable|string|max:255',
            'items.*.title.zh' => 'nullable|string|max:255',
            'items.*.target' => 'required|in:_self,_blank',
            'items.*.icon' => 'nullable|string|max:255',
            'items.*.css_class' => 'nullable|string|max:255',
            'items.*.navigation_menu_slug' => 'nullable|string|max:255',
            'items.*.order' => 'required|integer',
            'items.*.is_active' => 'boolean',
        ]);

        $validated = $request->only(['items']);

        // Map temp IDs to real IDs after creating items
        $idMap = [];

        // Delete existing items not in the new list (only real IDs)
        $itemIds = collect($validated['items'])
            ->pluck('id')
            ->filter(fn($id) => is_numeric($id) && !str_starts_with((string)$id, 'temp-'));
        $menu->items()->whereNotIn('id', $itemIds)->delete();

        // First pass: Create/update items without parent relationships
        foreach ($validated['items'] as $index => $itemData) {
            $id = $itemData['id'] ?? null;
            $isTemp = $id && str_starts_with((string)$id, 'temp-');

            $menuItem = (!$isTemp && $id && is_numeric($id))
                ? MenuItem::find($id)
                : new MenuItem(['menu_id' => $menu->id]);

            // Update or create menu item (without parent_id yet)
            $menuItem->fill([
                'menu_id' => $menu->id,
                'type' => $itemData['type'],
                'linkable_id' => $itemData['linkable_id'] ?? null,
                'linkable_type' => $itemData['linkable_type'] ?? null,
                'url' => $itemData['url'] ?? null,
                'order' => $itemData['order'],
                'target' => $itemData['target'],
                'icon' => $itemData['icon'] ?? null,
                'css_class' => $itemData['css_class'] ?? null,
                'navigation_menu_slug' => $itemData['navigation_menu_slug'] ?? null,
                'is_active' => $itemData['is_active'] ?? true,
            ]);

            $menuItem->save();

            // Map temp ID to real ID
            if ($isTemp) {
                $idMap[$id] = $menuItem->id;
            }

            // Save translations
            foreach ($itemData['title'] as $locale => $title) {
                if ($title) {
                    $menuItem->setTranslation('title', $locale, $title);
                }
            }

            // Store item reference for second pass
            $validated['items'][$index]['_menuItem'] = $menuItem;
        }

        // Second pass: Update parent relationships
        foreach ($validated['items'] as $itemData) {
            if (isset($itemData['parent_id']) && $itemData['parent_id']) {
                $menuItem = $itemData['_menuItem'];
                $parentId = $itemData['parent_id'];

                // Check if parent_id is a temp ID and map it to real ID
                if (str_starts_with((string)$parentId, 'temp-')) {
                    $parentId = $idMap[$parentId] ?? null;
                }

                if ($parentId) {
                    $menuItem->parent_id = $parentId;
                    $menuItem->save();
                }
            }
        }

        return redirect()->route('admin.menus.edit', $menu)
            ->with('success', 'Menu items saved successfully.');
    }

    /**
     * Reorder menu items.
     */
    public function reorderItems(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:menu_items,id',
            'items.*.order' => 'required|integer',
            'items.*.parent_id' => 'nullable|integer|exists:menu_items,id',
        ]);

        foreach ($validated['items'] as $itemData) {
            MenuItem::where('id', $itemData['id'])
                ->update([
                    'order' => $itemData['order'],
                    'parent_id' => $itemData['parent_id'] ?? null,
                ]);
        }

        return back()->with('success', 'Menu items reordered successfully.');
    }

    /**
     * Delete a menu item.
     */
    public function destroyItem(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->delete();

        return back()->with('success', 'Menu item deleted successfully.');
    }
}
