<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuAdminController extends Controller
{
    private function guard() {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;
        $menuItems = MenuItem::orderBy('location')->orderBy('sort_order')->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function store(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'location' => 'required|in:header,footer,sidebar',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        MenuItem::create($validated);
        return redirect()->route('admin.menu.index')->with('success', 'Menu item created!');
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        $item = MenuItem::findOrFail($id);
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'location' => 'required|in:header,footer,sidebar',
            'target' => 'nullable|in:_self,_blank',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);
        $validated['is_active'] = $request->has('is_active');
        $item->update($validated);
        return redirect()->route('admin.menu.index')->with('success', 'Menu item updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->guard()) return $r;
        MenuItem::findOrFail($id)->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu item deleted.');
    }
}