<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreAdminController extends Controller
{
    private function guard() {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;
        $genres = Genre::withCount('tracks')->orderBy('name')->paginate(20);
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        if ($r = $this->guard()) return $r;
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:genres',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
        ]);
        $slug = Str::slug($validated['name']);
        Genre::create(array_merge($validated, ['slug' => $slug]));
        return redirect()->route('admin.genres.index')->with('success', 'Genre created!');
    }

    public function edit($id)
    {
        if ($r = $this->guard()) return $r;
        $genre = Genre::findOrFail($id);
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        $genre = Genre::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:genres,name,' . $id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:50',
        ]);
        $genre->update($validated);
        return redirect()->route('admin.genres.index')->with('success', 'Genre updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->guard()) return $r;
        Genre::findOrFail($id)->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Genre deleted.');
    }
}