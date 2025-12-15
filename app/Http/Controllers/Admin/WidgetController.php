<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WidgetController extends Controller
{
    public function index()
    {
        $widgets = Widget::orderBy('order')->orderBy('created_at', 'desc')->paginate(20);

        return Inertia::render('Admin/Widgets/Index', [
            'widgets' => $widgets,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Widgets/Form', [
            'widget' => null,
            'types' => Widget::availableTypes(),
            'areas' => Widget::availableAreas(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:widgets,key|max:255',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(Widget::availableTypes())),
            'content' => 'nullable|array',
            'area' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Widget::create($validated);

        return redirect()->route('admin.widgets.index')
            ->with('success', 'Widget created successfully!');
    }

    public function edit(Widget $widget)
    {
        return Inertia::render('Admin/Widgets/Form', [
            'widget' => $widget,
            'types' => Widget::availableTypes(),
            'areas' => Widget::availableAreas(),
        ]);
    }

    public function update(Request $request, Widget $widget)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:widgets,key,' . $widget->id,
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(Widget::availableTypes())),
            'content' => 'nullable|array',
            'area' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $widget->update($validated);

        return redirect()->route('admin.widgets.index')
            ->with('success', 'Widget updated successfully!');
    }

    public function destroy(Widget $widget)
    {
        $widget->delete();

        return redirect()->route('admin.widgets.index')
            ->with('success', 'Widget deleted successfully!');
    }
}
