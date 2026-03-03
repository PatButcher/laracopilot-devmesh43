<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArtistAdminController extends Controller
{
    private function guard() {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;
        $artists = Artist::withCount('tracks')->orderBy('name')->paginate(20);
        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        if ($r = $this->guard()) return $r;
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url',
            'image' => 'nullable|image|max:5120',
        ]);
        $slug = Str::slug($validated['name']);
        $base = $slug; $i = 1;
        while (Artist::where('slug', $slug)->exists()) $slug = $base . '-' . $i++;
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $validated['image'] = $img->storeAs('artists', time() . '.' . $img->getClientOriginalExtension(), 'public');
        }
        Artist::create(array_merge($validated, ['slug' => $slug]));
        return redirect()->route('admin.artists.index')->with('success', 'Artist created!');
    }

    public function edit($id)
    {
        if ($r = $this->guard()) return $r;
        $artist = Artist::findOrFail($id);
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        $artist = Artist::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url',
            'image' => 'nullable|image|max:5120',
        ]);
        if ($request->hasFile('image')) {
            if ($artist->image) Storage::disk('public')->delete($artist->image);
            $img = $request->file('image');
            $validated['image'] = $img->storeAs('artists', time() . '.' . $img->getClientOriginalExtension(), 'public');
        }
        $artist->update($validated);
        return redirect()->route('admin.artists.index')->with('success', 'Artist updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->guard()) return $r;
        $artist = Artist::findOrFail($id);
        if ($artist->image) Storage::disk('public')->delete($artist->image);
        $artist->delete();
        return redirect()->route('admin.artists.index')->with('success', 'Artist deleted.');
    }
}